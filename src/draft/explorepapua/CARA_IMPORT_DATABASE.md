# 🎯 SOLUSI PASTI - Import Database Explore Papua

## ❌ MASALAH YANG ANDA ALAMI

Anda melihat struktur seperti ini di phpMyAdmin:
```
📁 explore_papua
   └─ Tables: orders, tours, users, view_orders_detail ✅ BENAR
📁 explore_papua_db 
   └─ Tables: orders, tours, tour_packages, users ❌ SALAH (database lama)
```

**PENYEBAB:** Anda punya **2 DATABASE BERBEDA**, bukan nested!
- `explore_papua_db` = Database LAMA dari proyek sebelumnya
- `explore_papua` = Database BARU dari file SQL saya

---

## ✅ SOLUSI 100% BERHASIL

### **🎬 VIDEO TUTORIAL (Langkah Visual)**

---

### **METODE 1: Import Otomatis (RECOMMENDED)**

#### **STEP 1: Buka phpMyAdmin**
```
URL: http://localhost/phpmyadmin
```

#### **STEP 2: Klik Tab "SQL" di BAGIAN ATAS**
⚠️ **PENTING:** JANGAN pilih database apapun dulu!
⚠️ Klik tab "SQL" yang ada di **BAGIAN ATAS** phpMyAdmin (bukan di dalam database)

Screenshot lokasi:
```
phpMyAdmin
┌─────────────────────────────────────┐
│ [Databases] [SQL] [Status] [Users] │  ← KLIK "SQL" DI SINI!
├─────────────────────────────────────┤
│ 📁 explore_papua                    │
│ 📁 explore_papua_db                 │
│ 📁 information_schema               │
└─────────────────────────────────────┘
```

#### **STEP 3: Copy-Paste File SQL**
1. Buka file `INSTALL_DATABASE.sql` dengan Notepad/VSCode
2. **Copy SEMUA isi file** (Ctrl+A → Ctrl+C)
3. **Paste** di kotak SQL di phpMyAdmin (Ctrl+V)
4. **Klik tombol "Go"** (pojok kanan bawah)

#### **STEP 4: Tunggu Proses Selesai**
Akan muncul pesan:
```
✅ Your SQL query has been executed successfully
✅ X queries executed
```

#### **STEP 5: Refresh phpMyAdmin**
Tekan **F5** atau klik tombol refresh browser

#### **STEP 6: VERIFIKASI Hasil**
Sekarang di sidebar seharusnya hanya ada:
```
📁 explore_papua          ← HANYA INI!
   └─ 📊 Tables (3)
       ├─ orders
       ├─ tours
       └─ users
   └─ 👁️ Views (1)
       └─ view_orders_detail
```

❌ **TIDAK ADA LAGI:** `explore_papua_db`

---

### **METODE 2: Manual via Import File**

#### **STEP 1: Hapus Database Lama**
1. phpMyAdmin → Klik `explore_papua_db` di sidebar
2. Tab "Operations"
3. Scroll ke bawah → "Drop the database (DROP)"
4. Konfirmasi

Lakukan hal yang sama untuk `explore_papua` (jika ada)

#### **STEP 2: Import File SQL**
1. phpMyAdmin → Klik "Import" di bagian atas
2. "Choose File" → Pilih `INSTALL_DATABASE.sql`
3. Format: SQL
4. Klik "Go"

#### **STEP 3: Refresh & Verifikasi**
F5 → Cek sidebar → Hanya ada 1 database: `explore_papua`

---

### **METODE 3: Via Terminal/Command Line**

Buka Command Prompt/Terminal:

```bash
# Masuk ke direktori MySQL
cd C:\xampp\mysql\bin

# Login ke MySQL
mysql -u root -p

# Masuk, lalu jalankan:
DROP DATABASE IF EXISTS explore_papua_db;
DROP DATABASE IF EXISTS explore_papua;
SOURCE D:/Organize/Projects/new/explore-papua-project/INSTALL_DATABASE.sql;

# Keluar
exit;
```

---

## 🔍 VERIFIKASI HASIL

### **Cek Database di phpMyAdmin**

Klik database `explore_papua` → Tab "SQL" → Jalankan:

```sql
-- Cek tabel
SHOW TABLES;
```

**Output yang BENAR:**
```
orders
tours
users
view_orders_detail
```

**Cek jumlah data:**
```sql
SELECT 'users' as tabel, COUNT(*) as jumlah FROM users
UNION ALL
SELECT 'tours', COUNT(*) FROM tours
UNION ALL
SELECT 'orders', COUNT(*) FROM orders;
```

**Output yang BENAR:**
```
tabel  | jumlah
-------|-------
users  | 4
tours  | 8
orders | 6
```

---

## 🎯 OUTPUT YANG SEHARUSNYA ANDA LIHAT

### **Di Sidebar phpMyAdmin:**
```
📁 explore_papua                    ← 1 DATABASE SAJA!
   ├─ 📊 Tables (3)
   │   ├─ orders           (6 rows)
   │   ├─ tours            (8 rows)
   │   └─ users            (4 rows)
   └─ 👁️ Views (1)
       └─ view_orders_detail
```

### **TIDAK BOLEH ADA:**
- ❌ `explore_papua_db`
- ❌ Tabel `tour_packages`
- ❌ Database nested/bertumpuk

---

## ⚙️ UPDATE CONFIG PHP

Setelah database berhasil, pastikan `includes/db.php`:

```php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'explore_papua';  // ✅ HARUS INI (bukan explore_papua_db)
```

---

## 🧪 TEST LOGIN

**Admin Panel:**
```
URL: http://localhost/explore-papua-project/admin_new.php
Email: admin@explorepapua.com
Password: password123
```

**User Dashboard:**
```
URL: http://localhost/explore-papua-project/dashboard.php
Email: john@example.com
Password: password123
```

---

## 🆘 TROUBLESHOOTING

### Error: "Database exists"
**Solusi:** Database lama masih ada. Hapus manual:
```sql
DROP DATABASE explore_papua_db;
DROP DATABASE explore_papua;
```

### Error: "Can't DROP database (database doesn't exist)"
**Solusi:** Itu normal. Artinya database memang belum ada. Lanjut saja.

### Masih muncul 2 database
**Solusi:** 
1. Clear cache browser (Ctrl+Shift+Delete)
2. Refresh phpMyAdmin dengan hard reload (Ctrl+F5)
3. Logout & login ulang ke phpMyAdmin

### Import gagal/timeout
**Solusi:** Gunakan METODE 1 (copy-paste SQL langsung)

---

## 📝 CHECKLIST AKHIR

- [ ] Hanya ada 1 database: `explore_papua`
- [ ] 3 tabel: users, tours, orders
- [ ] 1 view: view_orders_detail
- [ ] 4 users terdaftar
- [ ] 8 tours tersedia
- [ ] 6 orders sample
- [ ] TIDAK ADA: `explore_papua_db`
- [ ] TIDAK ADA: tabel `tour_packages`
- [ ] Login admin berhasil
- [ ] Login user berhasil

---

## 📦 FILE YANG HARUS DIGUNAKAN

✅ **`INSTALL_DATABASE.sql`** ← GUNAKAN INI!

File ini:
- ✅ Hapus database lama otomatis
- ✅ Buat database baru bersih
- ✅ Include verifikasi otomatis
- ✅ Tidak ada error/konflik

**JANGAN gunakan:**
- ❌ `explore_papua.sql` (versi lama)
- ❌ `explore_papua_clean.sql` (tidak sekomplit INSTALL_DATABASE.sql)

---

**🎉 Jika sudah berhasil, Anda akan melihat HANYA 1 database dengan 3 tabel yang benar!**

Silakan screenshot hasilnya jika masih ada masalah.
