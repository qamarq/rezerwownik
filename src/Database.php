<?php

declare(strict_types=1);

namespace App;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $dsn = sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
                $_ENV['DB_HOST'],
                $_ENV['DB_PORT'],
                $_ENV['DB_NAME']
            );

            try {
                self::$instance = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS'], [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
            } catch (PDOException $e) {
                die('<div style="font-family:monospace;color:red;padding:20px">
                    <strong>Błąd połączenia z bazą danych:</strong><br>' .
                    htmlspecialchars($e->getMessage()) . '
                    <br><br>Sprawdź plik <code>.env</code> i czy XAMPP MySQL jest uruchomiony.
                </div>');
            }
        }

        return self::$instance;
    }
}
