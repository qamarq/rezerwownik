<?php

declare(strict_types=1);

namespace App;

class Auth
{
    public static function check(): bool
    {
        return !empty($_SESSION['user_id']);
    }

    public static function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    public static function id(): ?int
    {
        return isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;
    }

    public static function role(): ?string
    {
        return $_SESSION['user_role'] ?? null;
    }

    public static function isStudent(): bool
    {
        return ($_SESSION['user_role'] ?? '') === 'student';
    }

    public static function isPracownik(): bool
    {
        return ($_SESSION['user_role'] ?? '') === 'pracownik';
    }

    public static function requireLogin(): void
    {
        if (!self::check()) {
            redirect('login');
        }
    }

    public static function requirePracownik(): void
    {
        self::requireLogin();
        if (!self::isPracownik()) {
            http_response_code(403);
            require __DIR__ . '/../views/errors/403.php';
            exit;
        }
    }

    public static function login(array $user): void
    {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
        $_SESSION['user'] = $user;
    }

    public static function logout(): void
    {
        $_SESSION = [];
        session_destroy();
    }
}
