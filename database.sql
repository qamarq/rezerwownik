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
('Adam',   'Myszka', 'adam.myszka@pwr.edu.pl',                 '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'pracownik'),
('Jan',    'Kowalski',      'jan.kowalski@student.pwr.edu.pl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student'),
('Anna',   'Nowak',         'anna.nowak@student.pwr.edu.pl',   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student'),
('Marek',  'Wiśniewski',    'marek.w@student.pwr.edu.pl',      '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student');

INSERT INTO rooms (name, building, floor, capacity, description) VALUES
('Sala ćwiczeniowa 164',      'A-1',  1,  36, 'Klasyczna sala ćwiczeniowa z tablicą suchościeralną'),
('Sala seminaryjna 168',      'A-1',  1,  24, 'Sala do konsultacji i spotkań projektowych'),
('Aula 241',                  'A-1',  2, 120, 'Duża aula wykładowa z projektorem i nagłośnieniem'),
('Sala wykładowa 244',        'A-1',  2,  72, 'Sala wykładowa z ekranem projekcyjnym'),
('Sala seminaryjna 322',      'A-1',  3,  24, 'Sala do seminariów i spotkań kół naukowych'),
('Pokój pracy grupowej 327',  'A-1',  3,  12, 'Mała sala do pracy zespołowej'),
('Laboratorium sieciowe 109', 'B-4',  1,  18, 'Laboratorium komputerowe z infrastrukturą sieciową'),
('Sala komputerowa 114',      'B-4',  1,  26, 'Sala komputerowa do zajęć laboratoryjnych'),
('Sala projektowa 205',       'B-4',  2,  16, 'Sala do pracy zespołowej z monitorem i tablicą'),
('Pracownia CAD 217',         'B-4',  2,  28, 'Pracownia komputerowa z oprogramowaniem inżynierskim'),
('Czytelnia techniczna',      'C-16', 0,  40, 'Cicha czytelnia do nauki indywidualnej'),
('Strefa nauki 0.18',         'C-16', 0,  18, 'Otwarta sala do samodzielnej nauki'),
('Sala konferencyjna 1.27',   'C-16', 1,  20, 'Sala z systemem wideokonferencji i ekranem'),
('Sala multimedialna 1.31',   'C-16', 1,  34, 'Sala z projektorem, nagłośnieniem i kamerą'),
('Pokój pracy grupowej 2.14', 'C-16', 2,   8, 'Mała sala do pracy w grupach projektowych'),
('Sala seminaryjna 2.22',     'C-16', 2,  18, 'Sala do seminariów dyplomowych'),
('Sala 3.05',                 'C-16', 3,  14, 'Kameralna sala z rzutnikiem i tablicą interaktywną'),
('Pracownia projektowa 3.12', 'C-16', 3,  22, 'Sala z dużymi stołami do pracy warsztatowej'),
('Laboratorium 012',          'D-1',  0,  22, 'Laboratorium dydaktyczne do zajęć praktycznych'),
('Sala ćwiczeniowa 018',      'D-1',  0,  30, 'Sala ćwiczeniowa na parterze z tablicą'),
('Sala 128',                  'D-1',  1,  32, 'Sala ćwiczeniowa w pobliżu dziekanatu'),
('Sala konsultacyjna 135',    'D-1',  1,  14, 'Kameralna sala do konsultacji i pracy zespołowej'),
('Sala 226',                  'D-1',  2,  26, 'Sala do zajęć projektowych i konsultacji'),
('Pracownia elektroniki 231', 'D-1',  2,  18, 'Pracownia z podstawowym wyposażeniem laboratoryjnym'),
('Aula 007',                  'D-21', 0,  90, 'Aula z miejscami audytoryjnymi i projektorem'),
('Sala warsztatowa 019',      'D-21', 0,  24, 'Sala warsztatowa z ruchomym układem stołów'),
('Sala komputerowa 115',      'D-21', 1,  30, 'Sala komputerowa z 30 stanowiskami'),
('Laboratorium automatyki 124','D-21',1,  20, 'Laboratorium z miejscami do pracy zespołowej'),
('Studio projektowe 112',     'H-4',  1,  24, 'Jasna sala ćwiczeniowa z ekranem projekcyjnym'),
('Sala konsultacyjna 118',    'H-4',  1,  16, 'Sala do konsultacji i pracy w małych grupach');

INSERT INTO reservations (user_id, room_id, reservation_date, start_time, end_time, purpose, status)
SELECT u.id, r.id, '2026-06-09', '08:00:00', '09:30:00', 'Praca nad projektem zespołowym', 'aktywna' FROM users u JOIN rooms r WHERE u.email = 'jan.kowalski@student.pwr.edu.pl' AND r.name = 'Pokój pracy grupowej 327'
UNION ALL SELECT u.id, r.id, '2026-06-09', '09:45:00', '11:15:00', 'Nauka do egzaminu', 'aktywna' FROM users u JOIN rooms r WHERE u.email = 'anna.nowak@student.pwr.edu.pl' AND r.name = 'Czytelnia techniczna'
UNION ALL SELECT u.id, r.id, '2026-06-09', '11:30:00', '13:00:00', 'Spotkanie koła naukowego', 'aktywna' FROM users u JOIN rooms r WHERE u.email = 'marek.w@student.pwr.edu.pl' AND r.name = 'Pokój pracy grupowej 2.14'
UNION ALL SELECT u.id, r.id, '2026-06-09', '13:15:00', '14:45:00', 'Konsultacje dla studentów', 'aktywna' FROM users u JOIN rooms r WHERE u.email = 'adam.myszka@pwr.edu.pl' AND r.name = 'Sala seminaryjna 168'
UNION ALL SELECT u.id, r.id, '2026-06-09', '16:00:00', '18:00:00', 'Ćwiczenia z baz danych', 'aktywna' FROM users u JOIN rooms r WHERE u.email = 'anna.nowak@student.pwr.edu.pl' AND r.name = 'Sala 128'
UNION ALL SELECT u.id, r.id, '2026-06-10', '08:30:00', '10:00:00', 'Warsztaty projektowe', 'aktywna' FROM users u JOIN rooms r WHERE u.email = 'marek.w@student.pwr.edu.pl' AND r.name = 'Sala projektowa 205'
UNION ALL SELECT u.id, r.id, '2026-06-10', '10:15:00', '11:45:00', 'Przygotowanie prezentacji', 'aktywna' FROM users u JOIN rooms r WHERE u.email = 'jan.kowalski@student.pwr.edu.pl' AND r.name = 'Sala konferencyjna 1.27'
UNION ALL SELECT u.id, r.id, '2026-06-10', '12:00:00', '13:30:00', 'Seminarium dyplomowe', 'aktywna' FROM users u JOIN rooms r WHERE u.email = 'adam.myszka@pwr.edu.pl' AND r.name = 'Sala wykładowa 244'
UNION ALL SELECT u.id, r.id, '2026-06-10', '14:00:00', '15:30:00', 'Laboratorium elektroniki', 'aktywna' FROM users u JOIN rooms r WHERE u.email = 'anna.nowak@student.pwr.edu.pl' AND r.name = 'Pracownia elektroniki 231'
UNION ALL SELECT u.id, r.id, '2026-06-10', '17:00:00', '19:00:00', 'Praca indywidualna', 'aktywna' FROM users u JOIN rooms r WHERE u.email = 'jan.kowalski@student.pwr.edu.pl' AND r.name = 'Sala 3.05'
UNION ALL SELECT u.id, r.id, '2026-06-11', '08:00:00', '10:00:00', 'Zajęcia laboratoryjne', 'aktywna' FROM users u JOIN rooms r WHERE u.email = 'anna.nowak@student.pwr.edu.pl' AND r.name = 'Sala komputerowa 114'
UNION ALL SELECT u.id, r.id, '2026-06-11', '10:30:00', '12:00:00', 'Warsztat projektowy', 'aktywna' FROM users u JOIN rooms r WHERE u.email = 'marek.w@student.pwr.edu.pl' AND r.name = 'Pracownia projektowa 3.12'
UNION ALL SELECT u.id, r.id, '2026-06-11', '12:15:00', '13:45:00', 'Konsultacje grupowe', 'aktywna' FROM users u JOIN rooms r WHERE u.email = 'jan.kowalski@student.pwr.edu.pl' AND r.name = 'Sala konsultacyjna 135'
UNION ALL SELECT u.id, r.id, '2026-06-11', '15:00:00', '16:30:00', 'Laboratorium automatyki', 'aktywna' FROM users u JOIN rooms r WHERE u.email = 'adam.myszka@pwr.edu.pl' AND r.name = 'Laboratorium automatyki 124'
UNION ALL SELECT u.id, r.id, '2026-06-11', '17:00:00', '18:30:00', 'Spotkanie projektowe', 'aktywna' FROM users u JOIN rooms r WHERE u.email = 'marek.w@student.pwr.edu.pl' AND r.name = 'Sala konsultacyjna 118';
