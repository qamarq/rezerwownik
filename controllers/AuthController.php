<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Auth;
use App\Models\User;
use PDO;

class AuthController
{
    private User $userModel;

    public function __construct(private PDO $db)
    {
        $this->userModel = new User($db);
    }

    public function loginForm(): void
    {
        if (Auth::check()) {
            redirect('rooms');
        }
        $pageTitle = 'Logowanie';
        require __DIR__ . '/../views/auth/login.php';
    }

    public function login(): void
    {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $user = $this->userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            $_SESSION['error'] = 'Nieprawidłowy adres e-mail lub hasło.';
            redirect('login');
        }

        if (!$user['is_active']) {
            $_SESSION['error'] = 'Twoje konto zostało zablokowane. Skontaktuj się z pracownikiem.';
            redirect('login');
        }

        Auth::login($user);
        redirect('rooms');
    }

    public function registerForm(): void
    {
        if (Auth::check()) {
            redirect('rooms');
        }
        $pageTitle = 'Rejestracja';
        require __DIR__ . '/../views/auth/register.php';
    }

    public function register(): void
    {
        $firstName = trim($_POST['first_name'] ?? '');
        $lastName = trim($_POST['last_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $password2 = $_POST['password2'] ?? '';

        if (!$firstName || !$lastName || !$email || !$password) {
            $_SESSION['error'] = 'Wszystkie pola są wymagane.';
            redirect('register');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Podaj poprawny adres e-mail.';
            redirect('register');
        }

        if (strlen($password) < 6) {
            $_SESSION['error'] = 'Hasło musi mieć co najmniej 6 znaków.';
            redirect('register');
        }

        if ($password !== $password2) {
            $_SESSION['error'] = 'Podane hasła nie są zgodne.';
            redirect('register');
        }

        if ($this->userModel->findByEmail($email)) {
            $_SESSION['error'] = 'Ten adres e-mail jest już zarejestrowany.';
            redirect('register');
        }

        $this->userModel->create($firstName, $lastName, $email, $password);
        $_SESSION['success'] = 'Konto zostało utworzone. Możesz się teraz zalogować.';
        redirect('login');
    }

    public function logout(): void
    {
        Auth::logout();
        redirect('login');
    }
}
