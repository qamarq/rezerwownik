<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Auth;
use App\Models\Reservation;
use PDO;

class ReservationController
{
    private Reservation $model;

    public function __construct(private PDO $db)
    {
        $this->model = new Reservation($db);
    }

    public function index(): void
    {
        Auth::requireLogin();
        $reservations = $this->model->forUser(Auth::id());
        $pageTitle = 'Moje rezerwacje';
        require __DIR__ . '/../views/reservations/index.php';
    }

    public function cancel(int $id): void
    {
        Auth::requireLogin();
        $reservation = $this->model->find($id);

        if (!$reservation || $reservation['status'] !== 'aktywna') {
            $_SESSION['error'] = 'Nie można anulować tej rezerwacji.';
            redirect('my-reservations');
        }

        if (Auth::isStudent() && (int)$reservation['user_id'] !== Auth::id()) {
            http_response_code(403);
            exit;
        }

        $this->model->cancel($id, Auth::id());
        $_SESSION['success'] = 'Rezerwacja została anulowana.';

        redirect(Auth::isPracownik() ? 'admin/reservations' : 'my-reservations');
    }
}
