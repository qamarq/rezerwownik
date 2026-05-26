<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\ReservationController;
use App\Controllers\RoomController;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

define(
    'APP_BASE',
    php_sapi_name() === 'cli-server'
        ? ''
        : rtrim($_ENV['APP_BASE'] ?? '/projekt', '/')
);

require_once __DIR__ . '/src/helpers.php';

$db = require __DIR__ . '/config/db.php';

session_start();

$url    = trim($_GET['url'] ?? '', '/');
$parts  = $url === '' ? [] : explode('/', $url);
$s0     = $parts[0] ?? '';
$s1     = $parts[1] ?? '';
$s2     = $parts[2] ?? '';
$s3     = $parts[3] ?? '';
$method = $_SERVER['REQUEST_METHOD'];

$numId = static fn(string $s): ?int => is_numeric($s) ? (int) $s : null;

if ($s0 === '' || $s0 === 'home') {
    if (\App\Auth::check()) {
        redirect('rooms');
    }
    $pageTitle = 'Strona główna';
    require __DIR__ . '/views/home.php';
    exit;
}

if ($s0 === 'login') {
    $ctrl = new AuthController($db);
    if ($s1 === 'store' && $method === 'POST') {
        $ctrl->login();
    } else {
        $ctrl->loginForm();
    }
    exit;
}

if ($s0 === 'register') {
    $ctrl = new AuthController($db);
    if ($s1 === 'store' && $method === 'POST') {
        $ctrl->register();
    } else {
        $ctrl->registerForm();
    }
    exit;
}

if ($s0 === 'logout') {
    (new AuthController($db))->logout();
    exit;
}

if ($s0 === 'rooms') {
    $ctrl = new RoomController($db);

    if ($s1 === 'reserve' && $numId($s2) !== null) {
        $id = $numId($s2);
        if ($method === 'POST') {
            $ctrl->reserve($id);
        } else {
            $ctrl->reserveForm($id);
        }
    } else {
        $ctrl->index();
    }
    exit;
}

if ($s0 === 'my-reservations') {
    $ctrl = new ReservationController($db);

    if ($s1 === 'cancel' && $numId($s2) !== null && $method === 'POST') {
        $ctrl->cancel($numId($s2));
    } else {
        $ctrl->index();
    }
    exit;
}

if ($s0 === 'admin') {
    $ctrl = new AdminController($db);

    if ($s1 === 'rooms') {
        if ($s2 === 'create' && $method === 'GET') {
            $ctrl->roomCreate();
        } elseif ($s2 === 'store' && $method === 'POST') {
            $ctrl->roomStore();
        } elseif ($s2 === 'edit' && $numId($s3) !== null && $method === 'GET') {
            $ctrl->roomEdit($numId($s3));
        } elseif ($s2 === 'update' && $numId($s3) !== null && $method === 'POST') {
            $ctrl->roomUpdate($numId($s3));
        } elseif ($s2 === 'delete' && $numId($s3) !== null && $method === 'POST') {
            $ctrl->roomDelete($numId($s3));
        } else {
            $ctrl->rooms();
        }
        exit;
    }

    if ($s1 === 'reservations') {
        $ctrl->reservations();
        exit;
    }

    if ($s1 === 'users') {
        if ($s2 === 'delete' && $numId($s3) !== null && $method === 'POST') {
            $ctrl->userDelete($numId($s3));
        } elseif ($s2 === 'toggle' && $numId($s3) !== null && $method === 'POST') {
            $ctrl->userToggle($numId($s3));
        } else {
            $ctrl->users();
        }
        exit;
    }

    redirect('admin/rooms');
    exit;
}

http_response_code(404);
$pageTitle = 'Nie znaleziono';
require __DIR__ . '/views/errors/404.php';
