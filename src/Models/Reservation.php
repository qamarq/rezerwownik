<?php

declare(strict_types=1);

namespace App\Models;

use PDO;

class Reservation
{
    public function __construct(private PDO $db)
    {
    }

    public function forUser(int $userId): array
    {
        $stmt = $this->db->prepare(
            'SELECT res.*, r.name AS room_name, r.building
             FROM reservations res
             JOIN rooms r ON res.room_id = r.id
             WHERE res.user_id = ?
             ORDER BY res.reservation_date DESC, res.start_time DESC'
        );
        $stmt->execute([$userId]);

        return $stmt->fetchAll();
    }

    public function all(): array
    {
        return $this->db->query(
            'SELECT res.*, r.name AS room_name, r.building,
                    u.first_name, u.last_name, u.email
             FROM reservations res
             JOIN rooms r ON res.room_id = r.id
             JOIN users u ON res.user_id = u.id
             ORDER BY res.reservation_date DESC, res.start_time DESC'
        )->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM reservations WHERE id = ?');
        $stmt->execute([$id]);

        return $stmt->fetch() ?: null;
    }

    public function hasConflict(int $roomId, string $date, string $start, string $end, ?int $excludeId = null): bool
    {
        $sql = 'SELECT COUNT(*) FROM reservations
                WHERE room_id = ? AND reservation_date = ? AND status = "aktywna"
                  AND start_time < ? AND end_time > ?';
        $params = [$roomId, $date, $end, $start];

        if ($excludeId !== null) {
            $sql .= ' AND id != ?';
            $params[] = $excludeId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return (int)$stmt->fetchColumn() > 0;
    }

    public function create(int $userId, int $roomId, string $date, string $start, string $end, string $purpose): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO reservations (user_id, room_id, reservation_date, start_time, end_time, purpose)
             VALUES (?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([$userId, $roomId, $date, $start, $end, $purpose]);

        return (int)$this->db->lastInsertId();
    }

    public function cancel(int $id, int $cancelledBy): void
    {
        $stmt = $this->db->prepare(
            'UPDATE reservations SET status = "anulowana", cancelled_by = ? WHERE id = ?'
        );
        $stmt->execute([$cancelledBy, $id]);
    }
}
