-- =============================================
-- CARA IMPORT DATABASE - BACA INI DULU!
-- =============================================

-- METODE 1: FRESH INSTALL (Recommended)
-- 1. Buka phpMyAdmin
-- 2. Klik "New" untuk buat database baru
-- 3. Nama database: explore_papua
-- 4. Klik "Create"
-- 5. Klik database "explore_papua" yang baru dibuat
-- 6. Klik tab "Import"
-- 7. Pilih file: explore_papua.sql
-- 8. Klik "Go"

-- METODE 2: Database Sudah Ada
-- 1. Buka phpMyAdmin
-- 2. Klik database "explore_papua"
-- 3. Klik tab "SQL"
-- 4. Copy paste script di bawah ini
-- 5. Klik "Go"

-- =============================================
-- CLEAN UP - Hapus tabel & view lama
-- =============================================
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS tours;
DROP TABLE IF EXISTS tour_packages;
DROP TABLE IF EXISTS users;
DROP VIEW IF EXISTS view_orders_detail;

SET FOREIGN_KEY_CHECKS = 1;

-- =============================================
-- TABEL 1: users (untuk akun user & admin)
-- =============================================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- TABEL 2: tours (data paket wisata)
-- =============================================
CREATE TABLE tours (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    location VARCHAR(100) NOT NULL,
    type ENUM('Open Trip', 'Private', 'Customized') DEFAULT 'Open Trip',
    price DECIMAL(12,2) NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    description TEXT,
    rating DECIMAL(2,1) DEFAULT 5.0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_location (location),
    INDEX idx_price (price),
    INDEX idx_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- TABEL 3: orders (pesanan tour)
-- =============================================
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_number VARCHAR(50) NOT NULL UNIQUE,
    user_id INT NOT NULL,
    tour_id INT NOT NULL,
    booking_date DATE NOT NULL,
    pax_count INT NOT NULL DEFAULT 1,
    total_price DECIMAL(12,2) NOT NULL,
    ktp_file VARCHAR(255),
    status ENUM('pending', 'paid', 'cancelled', 'confirmed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (tour_id) REFERENCES tours(id) ON DELETE CASCADE,
    INDEX idx_user (user_id),
    INDEX idx_tour (tour_id),
    INDEX idx_status (status),
    INDEX idx_invoice (invoice_number)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- DATA SAMPLE: Insert Admin & User
-- =============================================
-- Password untuk semua akun: "password123"
-- Hash dibuat dengan: password_hash('password123', PASSWORD_DEFAULT)
INSERT INTO users (full_name, email, password, role) VALUES
('Admin Papua', 'admin@explorepapua.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('John Doe', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Jane Smith', 'jane@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Budi Santoso', 'budi@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user');

-- =============================================
-- DATA SAMPLE: Insert Tours
-- =============================================
INSERT INTO tours (name, location, type, price, image_url, description, rating) VALUES
('Eksotisme Raja Ampat', 'Raja Ampat', 'Open Trip', 5500000.00, 'raja-ampat.jpg', 
'Jelajahi keindahan surga bawah laut Indonesia di Raja Ampat. Paket 4 hari 3 malam mencakup:\n- Snorkeling di spot terbaik\n- Kunjungan ke Wayag & Piaynemo\n- Penginapan homestay\n- Makan 3x sehari\n- Dokumentasi underwater', 5.0),

('Festival Lembah Baliem', 'Wamena', 'Private', 8500000.00, 'baliem.jpg',
'Saksikan festival budaya Papua terbesar di Lembah Baliem, Wamena. Paket 5 hari 4 malam:\n- Upacara adat suku Dani\n- Trekking ke desa tradisional\n- Penginapan hotel bintang 3\n- Pemandu lokal berpengalaman\n- Transportasi full AC', 5.0),

('Berenang dengan Hiu Paus', 'Nabire', 'Open Trip', 4200000.00, 'whale-shark.jpg',
'Pengalaman langka berenang bersama hiu paus di Teluk Cenderawasih. Paket 3 hari 2 malam:\n- Snorkeling dengan hiu paus\n- Diving spot premium\n- Penginapan kapal liveaboard\n- Peralatan snorkeling lengkap\n- Makan seafood segar', 4.8),

('Raja Ampat Premium Dive', 'Raja Ampat', 'Private', 12000000.00, 'raja-ampat-premium.jpg',
'Paket premium diving eksklusif dengan fasilitas bintang 5. Paket 7 hari 6 malam:\n- 12 sesi diving dengan instruktur\n- Resort mewah tepi pantai\n- Yacht pribadi untuk tour\n- Underwater photography professional\n- All-inclusive meals & drinks', 5.0),

('Wisata Danau Sentani', 'Jayapura', 'Open Trip', 2500000.00, 'sentani.jpg',
'Tour santai mengitari Danau Sentani yang memukau. Paket 2 hari 1 malam:\n- Keliling danau dengan perahu tradisional\n- Kunjungan ke pulau-pulau kecil\n- Belajar kerajinan kulit kayu\n- Penginapan resort tepi danau\n- Sunset cruise romantis', 4.5),

('Ekspedisi Gunung Carstensz', 'Mimika', 'Customized', 45000000.00, 'carstensz.jpg',
'Tantangan ultimate untuk pendaki profesional! Paket 14 hari:\n- Pendakian ke puncak tertinggi di Oceania\n- Peralatan climbing profesional\n- Sherpa & porter berpengalaman\n- Asuransi perjalanan lengkap\n- Dokumentasi ekspedisi', 5.0),

('Taman Nasional Lorentz', 'Timika', 'Private', 18000000.00, 'lorentz.jpg',
'Jelajahi situs warisan dunia UNESCO. Paket 6 hari 5 malam:\n- Trekking hutan hujan tropis\n- Wildlife spotting (burung cendrawasih)\n- Camping di alam liar\n- Pemandu ranger profesional\n- Dokumentasi biodiversity', 4.9),

('Pulau Biak Paradise', 'Biak', 'Open Trip', 3800000.00, 'biak.jpg',
'Nikmati pantai pasir putih dan sejarah Perang Dunia II. Paket 3 hari 2 malam:\n- Tour pantai-pantai eksotis\n- Kunjungan gua Jepang bersejarah\n- Snorkeling & island hopping\n- Penginapan hotel tepi pantai\n- BBQ seafood di pantai', 4.7);

-- =============================================
-- DATA SAMPLE: Insert Orders
-- =============================================
INSERT INTO orders (invoice_number, user_id, tour_id, booking_date, pax_count, total_price, status) VALUES
('INV-2024001', 2, 1, '2024-01-15', 2, 11000000.00, 'paid'),
('INV-2024002', 3, 3, '2024-01-20', 1, 4200000.00, 'paid'),
('INV-2024003', 2, 5, '2024-02-01', 3, 7500000.00, 'confirmed'),
('INV-2024004', 4, 2, '2024-02-10', 2, 17000000.00, 'pending'),
('INV-2024005', 3, 4, '2024-02-15', 1, 12000000.00, 'paid'),
('INV-2024006', 2, 8, '2024-03-01', 4, 15200000.00, 'cancelled');

-- =============================================
-- View untuk mempermudah query
-- =============================================
CREATE VIEW view_orders_detail AS
SELECT 
    o.id,
    o.invoice_number,
    o.booking_date,
    o.pax_count,
    o.total_price,
    o.status,
    o.created_at,
    u.full_name as customer_name,
    u.email as customer_email,
    t.name as tour_name,
    t.location as tour_location,
    t.type as tour_type
FROM orders o
JOIN users u ON o.user_id = u.id
JOIN tours t ON o.tour_id = t.id
ORDER BY o.created_at DESC;

-- =============================================
-- SELESAI!
-- =============================================
-- Untuk login:
-- Admin: admin@explorepapua.com / password123
-- User: john@example.com / password123
-- =============================================

-- VERIFIKASI: Cek apakah semua tabel berhasil dibuat
SELECT 'users' as tabel, COUNT(*) as jumlah_data FROM users
UNION ALL
SELECT 'tours', COUNT(*) FROM tours
UNION ALL
SELECT 'orders', COUNT(*) FROM orders;

-- Harusnya output:
-- users: 4
-- tours: 8
-- orders: 6
