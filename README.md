# Rezerwownik — System rezerwacji sal do nauki

Aplikacja webowa umożliwiająca studentom rezerwację sal do nauki na uczelni. Pracownicy (administratorzy) zarządzają salami i użytkownikami przez dedykowany panel.

> **Projekt W4** — autorzy: Kamil Marczak, Konrad Guzek

---

## Wymagania

- PHP 8.1+
- MySQL 5.7+ / MariaDB 10.4+
- Composer
- Apache z `mod_rewrite` **lub** wbudowany serwer PHP (do developmentu)

---

## Instalacja

### 1. Sklonuj repozytorium i zainstaluj zależności

```bash
git clone https://github.com/qamarq/rezerwownik
cd rezerwownik
composer install
```

### 2. Utwórz plik `.env`

```bash
cp .env.example .env
```

Uzupełnij dane połączenia z bazą:

```env
DB_HOST=localhost
DB_PORT=3306
DB_NAME=rezerwacje_sal
DB_USER=root
DB_PASS=
APP_NAME=Rezerwownik
```

### 3. Utwórz bazę danych

```bash
mysql -u root -p < database.sql
```

Skrypt tworzy bazę `rezerwacje_sal`, tabele oraz przykładowe dane testowe.

### 4. Uruchom aplikację

**Opcja A — wbudowany serwer PHP (development):**

```bash
composer dev
# Aplikacja dostępna pod http://localhost:8000
```

**Opcja B — Apache (XAMPP / serwer produkcyjny):**

Umieść projekt w katalogu `htdocs` (lub odpowiedniku) i upewnij się, że `mod_rewrite` jest włączony. Ustaw zmienną `APP_BASE` w `.env` jeśli aplikacja działa w podkatalogu:

```env
APP_BASE=/rezerwownik
```

---

## Konta testowe

Hasło dla wszystkich kont: **`password`**

| Rola       | E-mail                        |
|------------|-------------------------------|
| pracownik  | pracownik@uczelnia.pl         |
| student    | jan.kowalski@student.pl       |
| student    | anna.nowak@student.pl         |
| student    | marek.w@student.pl            |

---

## Funkcjonalności

### Studenci
- Przeglądanie listy dostępnych sal (nazwa, budynek, piętro, pojemność, opis)
- Rezerwacja sali na wybrany dzień i przedział godzinowy
- Podgląd własnych rezerwacji
- Anulowanie aktywnej rezerwacji

### Pracownicy (panel `/admin`)
- Dodawanie, edycja i usuwanie sal
- Aktywacja / dezaktywacja sal
- Podgląd wszystkich rezerwacji w systemie
- Zarządzanie kontami użytkowników (blokowanie, usuwanie)

---

## Struktura projektu

```
rezerwownik/
├── config/
│   └── db.php              # Połączenie z bazą danych (PDO)
├── controllers/
│   ├── AdminController.php
│   ├── AuthController.php
│   ├── ItemController.php
│   ├── ReservationController.php
│   └── RoomController.php
├── src/
│   ├── Auth.php            # Pomocnik sesji i autoryzacji
│   ├── Database.php
│   ├── helpers.php         # Funkcje pomocnicze (redirect itp.)
│   └── Models/
│       ├── Reservation.php
│       ├── Room.php
│       └── User.php
├── views/
│   ├── admin/              # Widoki panelu administratora
│   ├── auth/               # Logowanie i rejestracja
│   ├── errors/             # Strony błędów 403, 404
│   ├── partials/           # Header i footer
│   ├── reservations/       # Moje rezerwacje
│   └── rooms/              # Lista sal i formularz rezerwacji
├── vendor/                 # Zależności Composera
├── .env.example
├── .htaccess               # Przekierowanie wszystkich żądań przez index.php
├── composer.json
├── database.sql            # Schemat bazy i dane testowe
├── index.php               # Front controller / router
└── router.php              # Router dla wbudowanego serwera PHP
```

---

## Skrypty Composera

| Komenda            | Opis                                    |
|--------------------|-----------------------------------------|
| `composer dev`     | Uruchamia wbudowany serwer PHP          |
| `composer fmt`     | Sprawdza formatowanie kodu (dry-run)    |
| `composer fmt:fix` | Poprawia formatowanie kodu (PHP CS Fixer) |

---

## Schemat bazy danych

| Tabela         | Opis                                         |
|----------------|----------------------------------------------|
| `users`        | Konta użytkowników (studenci i pracownicy)   |
| `rooms`        | Sale do nauki z opisem i pojemnością         |
| `reservations` | Rezerwacje powiązane z użytkownikiem i salą  |

Role użytkowników: `student` | `pracownik`  
Statusy rezerwacji: `aktywna` | `anulowana`
