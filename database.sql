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
('Sala A101',          'Budynek A',  1, 20, 'Sala komputerowa z 20 stanowiskami i rzutnikiem'),
('Sala B205',          'Budynek B',  2, 15, 'Sala cicha do nauki indywidualnej i pracy w małych grupach'),
('Sala C310',          'Budynek C',  3,  8, 'Mała sala do pracy grupowej z tablicą interaktywną'),
('Czytelnia',          'Biblioteka', 0, 30, 'Czytelnia główna — strefa ciszy, dostępna całą dobę'),
('Sala Konferencyjna', 'Budynek A',  2, 12, 'Sala z projektorem, tablicą i systemem wideokonferencji'),
('Pracownia D402',     'Budynek D',  4, 25, 'Pracownia komputerowa z oprogramowaniem inżynierskim');
