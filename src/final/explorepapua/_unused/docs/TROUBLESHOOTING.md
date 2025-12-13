# 🔧 TROUBLESHOOTING - Import Database

## ❌ Masalah: Tabel Tidak Sesuai (Ada `tour_packages`)

### **Penyebab:**
Database `explore_papua` atau `explore_papua_db` sudah ada sebelumnya dengan struktur lama.

### **Solusi:**

---

## ✅ **METODE 1: Fresh Install (RECOMMENDED)**

### Langkah-langkah:

1. **Hapus Database Lama**
   ```
   phpMyAdmin → Klik database "explore_papua_db" atau "explore_papua" 
   → Tab "Operations" 
   → Scroll ke bawah 
   → "Drop the database (DROP)" 
   → Konfirmasi
   ```

2. **Buat Database Baru**
   ```
   Klik "New" di sidebar kiri
   Database name: explore_papua
   Collation: utf8mb4_general_ci
   Klik "Create"
   ```

3. **Import SQL**
   ```
   Klik database "explore_papua" yang baru
   → Tab "Import"
   → Choose File: explore_papua_clean.sql
   → Format: SQL
   → Klik "Go"
   ```

4. **Verifikasi**
   ```
   Seharusnya muncul 4 tabel:
   ✅ users (4 rows)
   ✅ tours (8 rows)
   ✅ orders (6 rows)
   ✅ Views (1 view: view_orders_detail)
   
   ❌ TIDAK ADA: tour_packages
   ```

---

## ✅ **METODE 2: Copy-Paste SQL (Jika Import Gagal)**

1. **Buka file `explore_papua_clean.sql`** dengan text editor

2. **Copy SEMUA isi file** (Ctrl+A → Ctrl+C)

3. **Buka phpMyAdmin**
   ```
   Klik database "explore_papua"
   → Tab "SQL"
   → Paste semua code (Ctrl+V)
   → Klik "Go"
   ```

4. **Tunggu sampai selesai**
   - Harus muncul pesan: "X queries executed successfully"

---

## ✅ **METODE 3: Manual Cleanup (Database Sudah Ada)**

Jika tidak ingin hapus database, jalankan SQL ini terlebih dahulu:

```sql
-- 1. Nonaktifkan foreign key check
SET FOREIGN_KEY_CHECKS = 0;

-- 2. Hapus tabel lama
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS tours;
DROP TABLE IF EXISTS tour_packages;  -- Tabel lama yang tidak terpakai
DROP TABLE IF EXISTS users;
DROP VIEW IF EXISTS view_orders_detail;

-- 3. Aktifkan kembali
SET FOREIGN_KEY_CHECKS = 1;
```

**Cara execute:**
```
phpMyAdmin → Database "explore_papua" 
→ Tab "SQL" 
→ Paste code di atas 
→ "Go"
```

Setelah itu, **import ulang** `explore_papua_clean.sql`

---

## 🔍 **VERIFIKASI HASIL**

Jalankan query ini untuk cek data:

```sql
SELECT 'users' as tabel, COUNT(*) as jumlah FROM users
UNION ALL
SELECT 'tours', COUNT(*) FROM tours
UNION ALL
SELECT 'orders', COUNT(*) FROM orders;
```

**Output yang benar:**
```
tabel   | jumlah
--------|-------
users   | 4
tours   | 8
orders  | 6
```

---

## ⚠️ **Error yang Sering Muncul**

### Error: "Table 'orders' already exists"
**Solusi:** Jalankan cleanup SQL terlebih dahulu (Metode 3)

### Error: "Cannot add foreign key constraint"
**Solusi:** 
```sql
SET FOREIGN_KEY_CHECKS = 0;
-- Jalankan import
SET FOREIGN_KEY_CHECKS = 1;
```

### Error: "Unknown database 'explore_papua'"
**Solusi:** Buat database dulu dengan nama `explore_papua`

### Import terlalu lama / timeout
**Solusi:** 
1. Gunakan METODE 2 (copy-paste SQL)
2. Atau tingkatkan `max_execution_time` di php.ini

---

## 📝 **Update Config Database**

Setelah berhasil import, pastikan `includes/db.php` sudah benar:

```php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'explore_papua';  // ← HARUS SAMA dengan nama database
```

**BUKAN:**
```php
$db = 'explore_papua_db';  // ❌ SALAH jika database bernama explore_papua
```

---

## ✅ **Checklist Setelah Import**

- [ ] 4 tabel ada: users, tours, orders, (tidak ada tour_packages)
- [ ] 1 view ada: view_orders_detail
- [ ] 4 users terdaftar (1 admin, 3 user)
- [ ] 8 tours tersedia
- [ ] 6 orders sample
- [ ] Login admin berhasil: admin@explorepapua.com / password123
- [ ] Login user berhasil: john@example.com / password123

---

## 🆘 **Masih Bermasalah?**

### Screenshot yang Perlu Dikirim:
1. Struktur tabel di phpMyAdmin (sidebar Tables)
2. Error message lengkap
3. Isi file `includes/db.php`

### Atau Gunakan SQL Backup Manual:

**File yang tersedia:**
- `explore_papua.sql` - Versi original
- `explore_papua_clean.sql` - Versi dengan cleanup otomatis (RECOMMENDED)

Pilih `explore_papua_clean.sql` untuk hasil terbaik!

---

**Updated:** 11 Desember 2025
