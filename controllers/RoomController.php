<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Auth;
use App\Models\Reservation;
use App\Models\Room;
use PDO;

class RoomController
{
    private Room        $roomModel;
    private Reservation $reservationModel;

    public function __construct(private PDO $db)
    {
        $this->roomModel = new Room($db);
        $this->reservationModel = new Reservation($db);
    }

    public function index(): void
    {
        Auth::requireLogin();
        $date = $_GET['date'] ?? date('Y-m-d');
        $filters = [
            'building' => trim($_GET['building'] ?? ''),
            'floor' => $_GET['floor'] ?? '',
            'capacity' => $_GET['capacity'] ?? '',
        ];
        $sort = $_GET['sort'] ?? 'name';
        $filterOptions = $this->roomModel->getFilterOptions();
        $rooms = $this->roomModel->getWithBookingCount($date, $filters, $sort);
        $pageTitle = 'Dostępne sale';
        require __DIR__ . '/../views/rooms/index.php';
    }

    public function reserveForm(int $id): void
    {
        Auth::requireLogin();
        $room = $this->roomModel->find($id);
        if (!$room || !$room['is_active']) {
            $this->notFound();

            return;
        }

        $date = $_GET['date'] ?? date('Y-m-d');
        $reservations = $this->roomModel->getReservationsForDate($id, $date);
        $pageTitle = 'Rezerwacja sali';
        require __DIR__ . '/../views/rooms/reserve.php';
    }

    public function reserve(int $id): void
    {
        Auth::requireLogin();
        $room = $this->roomModel->find($id);
        if (!$room || !$room['is_active']) {
            $this->notFound();

            return;
        }

        $date = $_POST['date'] ?? '';
        $start = $_POST['start_time'] ?? '';
        $end = $_POST['end_time'] ?? '';
        $purpose = trim($_POST['purpose'] ?? '');

        if (!$date || !$start || !$end) {
            $_SESSION['error'] = 'Wypełnij wszystkie wymagane pola.';
            redirect("rooms/reserve/$id?date=$date");
        }

        if ($start >= $end) {
            $_SESSION['error'] = 'Godzina zakończenia musi być późniejsza niż godzina rozpoczęcia.';
            redirect("rooms/reserve/$id?date=$date");
        }

        if ($date < date('Y-m-d')) {
            $_SESSION['error'] = 'Nie można rezerwować sal na dni przeszłe.';
            redirect("rooms/reserve/$id?date=$date");
        }

        if ($this->reservationModel->hasConflict($id, $date, $start, $end)) {
            $_SESSION['error'] = 'Sala jest już zarezerwowana w wybranym przedziale czasowym. Wybierz inny termin.';
            redirect("rooms/reserve/$id?date=$date");
        }

        $this->reservationModel->create(Auth::id(), $id, $date, $start, $end, $purpose);
        $_SESSION['success'] = 'Rezerwacja została złożona pomyślnie!';
        redirect('my-reservations');
    }

    private function notFound(): void
    {
        http_response_code(404);
        $pageTitle = 'Nie znaleziono';
        require __DIR__ . '/../views/errors/404.php';
    }
}
