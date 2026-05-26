<?php

declare(strict_types=1);

namespace App\Controllers;

use PDO;

class ItemController
{
    public function __construct(private PDO $db)
    {
    }

    public function index(): void
    {
        $stmt = $this->db->query('SELECT * FROM items ORDER BY id DESC');
        $items = $stmt->fetchAll();
        require __DIR__ . '/../views/items/index.php';
    }

    public function create(): void
    {
        require __DIR__ . '/../views/items/create.php';
    }

    public function store(): void
    {
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if ($name === '') {
            $_SESSION['error'] = 'Nazwa jest wymagana.';
            header('Location: /projekt/items/create');
            exit;
        }

        $stmt = $this->db->prepare('INSERT INTO items (name, description) VALUES (?, ?)');
        $stmt->execute([$name, $description]);

        $_SESSION['success'] = 'Rekord dodany pomyślnie.';
        header('Location: /projekt/items');
        exit;
    }

    public function edit(int $id): void
    {
        $stmt = $this->db->prepare('SELECT * FROM items WHERE id = ?');
        $stmt->execute([$id]);
        $item = $stmt->fetch();

        if (!$item) {
            $this->notFound();

            return;
        }

        require __DIR__ . '/../views/items/edit.php';
    }

    public function update(int $id): void
    {
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if ($name === '') {
            $_SESSION['error'] = 'Nazwa jest wymagana.';
            header("Location: /projekt/items/edit/$id");
            exit;
        }

        $stmt = $this->db->prepare('UPDATE items SET name = ?, description = ? WHERE id = ?');
        $stmt->execute([$name, $description, $id]);

        $_SESSION['success'] = 'Rekord zaktualizowany.';
        header('Location: /projekt/items');
        exit;
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM items WHERE id = ?');
        $stmt->execute([$id]);

        $_SESSION['success'] = 'Rekord usunięty.';
        header('Location: /projekt/items');
        exit;
    }

    private function notFound(): void
    {
        http_response_code(404);
        echo '<h2>404 — Nie znaleziono rekordu</h2>';
    }
}
