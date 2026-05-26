<?php

declare(strict_types=1);

namespace App\Models;

use PDO;

class User
{
    public function __construct(private PDO $db)
    {
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);

        return $stmt->fetch() ?: null;
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);

        return $stmt->fetch() ?: null;
    }

    public function create(string $firstName, string $lastName, string $email, string $password): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO users (first_name, last_name, email, password_hash, role) VALUES (?, ?, ?, ?, "student")'
        );
        $stmt->execute([$firstName, $lastName, $email, password_hash($password, PASSWORD_BCRYPT)]);

        return (int)$this->db->lastInsertId();
    }

    public function all(): array
    {
        return $this->db->query(
            'SELECT id, first_name, last_name, email, role, is_active, created_at
             FROM users ORDER BY role DESC, last_name, first_name'
        )->fetchAll();
    }

    public function toggleActive(int $id): void
    {
        $stmt = $this->db->prepare('UPDATE users SET is_active = NOT is_active WHERE id = ?');
        $stmt->execute([$id]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM users WHERE id = ?');
        $stmt->execute([$id]);
    }
}
