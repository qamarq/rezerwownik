<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Auth;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use PDO;

class AdminController
{
    private Room        $roomModel;
    private Reservation $reservationModel;
    private User        $userModel;

    public function __construct(private PDO $db)
    {
        Auth::requirePracownik();
        $this->roomModel = new Room($db);
        $this->reservationModel = new Reservation($db);
        $this->userModel = new User($db);
    }

    public function rooms(): void
    {
        $rooms = $this->roomModel->all();
        $pageTitle = 'Zarządzanie salami';
        require __DIR__ . '/../views/admin/rooms/index.php';
    }

    public function roomCreate(): void
    {
        $pageTitle = 'Dodaj salę';
        require __DIR__ . '/../views/admin/rooms/create.php';
    }

    public function roomStore(): void
    {
        $data = $this->roomDataFromPost();
        if ($data === null) {
            redirect('admin/rooms/create');
        }
        $this->roomModel->create($data);
        $_SESSION['success'] = 'Sala została dodana.';
        redirect('admin/rooms');
    }

    public function roomEdit(int $id): void
    {
        $room = $this->roomModel->find($id);
        if (!$room) {
            $this->notFound();

            return;
        }
        $pageTitle = 'Edytuj salę';
        require __DIR__ . '/../views/admin/rooms/edit.php';
    }

    public function roomUpdate(int $id): void
    {
        $room = $this->roomModel->find($id);
        if (!$room) {
            $this->notFound();

            return;
        }

        $data = $this->roomDataFromPost(withActive: true);
        if ($data === null) {
            redirect("admin/rooms/edit/$id");
        }

        $this->roomModel->update($id, $data);
        $_SESSION['success'] = 'Sala została zaktualizowana.';
        redirect('admin/rooms');
    }

    public function roomDelete(int $id): void
    {
        $this->roomModel->delete($id);
        $_SESSION['success'] = 'Sala została usunięta.';
        redirect('admin/rooms');
    }

    public function reservations(): void
    {
        $reservations = $this->reservationModel->all();
        $pageTitle = 'Wszystkie rezerwacje';
        require __DIR__ . '/../views/admin/reservations/index.php';
    }

    public function users(): void
    {
        $users = $this->userModel->all();
        $pageTitle = 'Zarządzanie użytkownikami';
        require __DIR__ . '/../views/admin/users/index.php';
    }

    public function userDelete(int $id): void
    {
        if ($id === Auth::id()) {
            $_SESSION['error'] = 'Nie możesz usunąć własnego konta.';
            redirect('admin/users');
        }
        $this->userModel->delete($id);
        $_SESSION['success'] = 'Użytkownik został usunięty.';
        redirect('admin/users');
    }

    public function userToggle(int $id): void
    {
        if ($id === Auth::id()) {
            $_SESSION['error'] = 'Nie możesz zablokować własnego konta.';
            redirect('admin/users');
        }
        $this->userModel->toggleActive($id);
        $_SESSION['success'] = 'Status konta został zmieniony.';
        redirect('admin/users');
    }

    private function roomDataFromPost(bool $withActive = false): ?array
    {
        $name = trim($_POST['name'] ?? '');
        $building = trim($_POST['building'] ?? '');
        $floor = (int)($_POST['floor'] ?? 0);
        $capacity = (int)($_POST['capacity'] ?? 0);
        $description = trim($_POST['description'] ?? '');

        if (!$name || !$building || $capacity < 1) {
            $_SESSION['error'] = 'Nazwa, budynek i pojemność (min. 1) są wymagane.';

            return null;
        }

        $data = compact('name', 'building', 'floor', 'capacity', 'description');

        if ($withActive) {
            $data['is_active'] = isset($_POST['is_active']) ? 1 : 0;
        }

        return $data;
    }

    private function notFound(): void
    {
        http_response_code(404);
        require __DIR__ . '/../views/errors/404.php';
    }
}
