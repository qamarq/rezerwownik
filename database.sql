-- System rezerwacji sal do nauki dla studentów
-- Uruchom: mysql -u root -p < database.sql

CREATE DATABASE IF NOT EXISTS rezerwacje_sal
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE rezerwacje_sal;

-- -------------------------------------------------------
-- Tabela użytkowników (studenci i pracownicy)
-- -------------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
    id            INT UNSIGNED     AUTO_INCREMENT PRIMARY KEY,
    first_name    VARCHAR(100)     NOT NULL,
    last_name     VARCHAR(100)     NOT NULL,
    email         VARCHAR(255)     NOT NULL UNIQUE,
    password_hash VARCHAR(255)     NOT NULL,
    role          ENUM('student','pracownik') NOT NULL DEFAULT 'student',
    is_active     TINYINT(1)       NOT NULL DEFAULT 1,
    created_at    TIMESTAMP        DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------
-- Tabela sal
-- -------------------------------------------------------
CREATE TABLE IF NOT EXISTS rooms (
    id          INT UNSIGNED  AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100)  NOT NULL,
    building    VARCHAR(100)  NOT NULL DEFAULT '',
    floor       TINYINT       NOT NULL DEFAULT 0,
    capacity    TINYINT UNSIGNED NOT NULL DEFAULT 10,
    description TEXT,
    is_active   TINYINT(1)    NOT NULL DEFAULT 1,
    created_at  TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------
-- Tabela rezerwacji
-- -------------------------------------------------------
CREATE TABLE IF NOT EXISTS reservations (
    id               INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id          INT UNSIGNED NOT NULL,
    room_id          INT UNSIGNED NOT NULL,
    reservation_date DATE         NOT NULL,
    start_time       TIME         NOT NULL,
    end_time         TIME         NOT NULL,
    purpose          VARCHAR(255),
    status           ENUM('aktywna','anulowana') NOT NULL DEFAULT 'aktywna',
    cancelled_by     INT UNSIGNED DEFAULT NULL,
    created_at       TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    updated_at       TIMESTAMP    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id)      REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (room_id)      REFERENCES rooms(id) ON DELETE CASCADE,
    FOREIGN KEY (cancelled_by) REFERENCES users(id) ON DELETE SET NULL,

    INDEX idx_date_room (reservation_date, room_id),
    INDEX idx_user      (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------
-- Dane testowe
-- Hasło dla wszystkich kont: password
-- -------------------------------------------------------
INSERT INTO users (first_name, last_name, email, password_hash, role) VALUES
('Adam',   'Pracownik', 'pracownik@uczelnia.pl',   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'pracownik'),
('Jan',    'Kowalski',  'jan.kowalski@student.pl',  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student'),
('Anna',   'Nowak',     'anna.nowak@student.pl',    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student'),
('Marek',  'Wiśniewski','marek.w@student.pl',       '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student');

INSERT INTO rooms (name, building, floor, capacity, description) VALUES
('Aula 241',                 'A-1',  2, 120, 'Duża aula wykładowa z projektorem i nagłośnieniem'),
('Sala 164',                 'A-1',  1,  36, 'Klasyczna sala ćwiczeniowa z tablicą suchościeralną'),
('Sala seminaryjna 322',     'A-1',  3,  24, 'Sala do seminariów i spotkań kół naukowych'),
('Laboratorium sieciowe 109', 'B-4',  1,  18, 'Laboratorium komputerowe z infrastrukturą sieciową'),
('Sala projektowa 205',      'B-4',  2,  16, 'Sala do pracy zespołowej z monitorem i tablicą'),
('Pracownia CAD 317',        'B-4',  3,  28, 'Pracownia komputerowa z oprogramowaniem inżynierskim'),
('Czytelnia techniczna',     'C-16', 0,  40, 'Cicha czytelnia do nauki indywidualnej'),
('Sala konferencyjna 1.27',  'C-16', 1,  20, 'Sala z systemem wideokonferencji i ekranem'),
('Pokój pracy grupowej 2.14','C-16', 2,   8, 'Mała sala do pracy w grupach projektowych'),
('Sala 3.05',                'C-16', 3,  14, 'Kameralna sala z rzutnikiem i tablicą interaktywną'),
('Laboratorium 012',         'D-1',  0,  22, 'Laboratorium dydaktyczne do zajęć praktycznych'),
('Sala 128',                 'D-1',  1,  32, 'Sala ćwiczeniowa w pobliżu dziekanatu'),
('Sala 226',                 'D-1',  2,  26, 'Sala do zajęć projektowych i konsultacji'),
('Pracownia elektroniki 304','D-1',  3,  18, 'Pracownia z podstawowym wyposażeniem laboratoryjnym'),
('Aula 007',                 'D-21', 0,  90, 'Aula z miejscami audytoryjnymi i projektorem'),
('Sala komputerowa 115',     'D-21', 1,  30, 'Sala komputerowa z 30 stanowiskami'),
('Sala seminaryjna 218',     'D-21', 2,  18, 'Sala do seminariów dyplomowych'),
('Laboratorium automatyki 331','D-21',3,  20, 'Laboratorium z miejscami do pracy zespołowej'),
('Studio projektowe 041',    'H-4',  0,  12, 'Sala warsztatowa z dużymi stołami projektowymi'),
('Sala 112',                 'H-4',  1,  24, 'Jasna sala ćwiczeniowa z ekranem projekcyjnym'),
('Sala 214',                 'H-4',  2,  16, 'Sala do konsultacji i pracy w małych grupach'),
('Laboratorium materiałowe 305','H-4',3,  20, 'Laboratorium dydaktyczne z zapleczem technicznym'),
('Sala multimedialna 101',   'C-13', 1,  34, 'Sala z projektorem, nagłośnieniem i kamerą'),
('Pokój cichej nauki 204',   'C-13', 2,  10, 'Niewielka sala do nauki indywidualnej');
