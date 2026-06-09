<?php

declare(strict_types=1);

namespace App\Models;

use PDO;

class Room
{
    public function __construct(private PDO $db)
    {
    }

    public function all(bool $activeOnly = false): array
    {
        $sql = 'SELECT * FROM rooms';
        if ($activeOnly) {
            $sql .= ' WHERE is_active = 1';
        }
        $sql .= ' ORDER BY name';

        return $this->db->query($sql)->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM rooms WHERE id = ?');
        $stmt->execute([$id]);

        return $stmt->fetch() ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO rooms (name, building, floor, capacity, description) VALUES (?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $data['name'],
            $data['building'],
            $data['floor'],
            $data['capacity'],
            $data['description'],
        ]);

        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $stmt = $this->db->prepare(
            'UPDATE rooms SET name=?, building=?, floor=?, capacity=?, description=?, is_active=? WHERE id=?'
        );
        $stmt->execute([
            $data['name'],
            $data['building'],
            $data['floor'],
            $data['capacity'],
            $data['description'],
            $data['is_active'],
            $id,
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM rooms WHERE id = ?');
        $stmt->execute([$id]);
    }

    public function getFilterOptions(): array
    {
        return [
            'buildings' => $this->db->query(
                'SELECT DISTINCT building FROM rooms WHERE is_active = 1 ORDER BY building'
            )->fetchAll(PDO::FETCH_COLUMN),
            'floors' => $this->db->query(
                'SELECT DISTINCT floor FROM rooms WHERE is_active = 1 ORDER BY floor'
            )->fetchAll(PDO::FETCH_COLUMN),
            'capacities' => $this->db->query(
                'SELECT DISTINCT capacity FROM rooms WHERE is_active = 1 ORDER BY capacity'
            )->fetchAll(PDO::FETCH_COLUMN),
        ];
    }

    public function getWithBookingCount(string $date, array $filters = [], string $sort = 'name'): array
    {
        $where = ['r.is_active = 1'];
        $params = [$date];

        if (!empty($filters['building'])) {
            $where[] = 'r.building = ?';
            $params[] = $filters['building'];
        }

        if (isset($filters['floor']) && $filters['floor'] !== '') {
            $where[] = 'r.floor = ?';
            $params[] = (int)$filters['floor'];
        }

        if (!empty($filters['capacity'])) {
            $where[] = 'r.capacity >= ?';
            $params[] = (int)$filters['capacity'];
        }

        $orderBy = match ($sort) {
            'capacity_asc' => 'r.capacity ASC, r.name ASC',
            'capacity_desc' => 'r.capacity DESC, r.name ASC',
            'bookings_asc' => 'bookings_count ASC, r.name ASC',
            'bookings_desc' => 'bookings_count DESC, r.name ASC',
            default => 'r.name ASC',
        };

        $stmt = $this->db->prepare(
            'SELECT r.*,
                    COUNT(CASE WHEN res.status = "aktywna" THEN 1 END) AS bookings_count
             FROM rooms r
             LEFT JOIN reservations res
                ON r.id = res.room_id AND res.reservation_date = ?
             WHERE ' . implode(' AND ', $where) . '
             GROUP BY r.id
             ORDER BY ' . $orderBy
        );
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function getReservationsForDate(int $roomId, string $date): array
    {
        $stmt = $this->db->prepare(
            'SELECT res.*, u.first_name, u.last_name
             FROM reservations res
             JOIN users u ON res.user_id = u.id
             WHERE res.room_id = ? AND res.reservation_date = ? AND res.status = "aktywna"
             ORDER BY res.start_time'
        );
        $stmt->execute([$roomId, $date]);

        return $stmt->fetchAll();
    }
}
