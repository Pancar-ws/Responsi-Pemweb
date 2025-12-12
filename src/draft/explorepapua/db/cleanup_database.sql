-- =============================================
-- CLEANUP SCRIPT - Hapus Database Lama
-- =============================================
-- CARA PAKAI:
-- 1. Buka phpMyAdmin
-- 2. Klik tab "SQL" (di bagian atas, bukan di database tertentu)
-- 3. Copy-paste script ini
-- 4. Klik "Go"
-- =============================================

-- Hapus database lama yang tidak terpakai
DROP DATABASE IF EXISTS explore_papua_db;

-- Hapus database explore_papua juga (untuk fresh install)
DROP DATABASE IF EXISTS explore_papua;

-- Buat database baru yang bersih
CREATE DATABASE explore_papua CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Gunakan database yang baru dibuat
USE explore_papua;

-- =============================================
-- Sekarang jalankan script di bawah ini
-- (atau import file explore_papua.sql)
-- =============================================
