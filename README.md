# Responsi-Pemweb
## Ide 1 “PapuaTiket” – Platform Pemesanan Tiket Wisata & Homestay Papua

**Kelebihan**
- Mirip Traveloka mini → sangat sesuai dengan ide awal
- Tema Papua sangat kuat (Raja Ampat, Baliem, Wasur, dll)
- Mudah dibagi tugas
- Bisa nilai tambah tinggi karena ada transaksi

**2 Jenis Akun**
1. Pengunjung (User biasa)
2. Pengelola Objek Wisata / Homestay (Vendor)

**Tabel Database** (total 5 tabel, tapi Anda cukup buat 4–5 juga aman)
1. users (id, name, email, password, role: 'pengunjung'/'vendor', no_hp)
2. wisata (id, nama_wisata, lokasi, harga_tiket, deskripsi, foto, vendor_id)
3. homestay (id, nama, lokasi, harga_per_malam, fasilitas, foto, vendor_id)
4. pemesanan_tiket (id, user_id, wisata_id, tanggal_kunjungan, jumlah_orang, total_harga, status)
5. pemesanan_homestay (opsional)

**Halaman (lebih dari 4, tetap ringan)**
1. Login
2. Register (pilih role: pengunjung atau vendor)
3. Dashboard Pengunjung (daftar wisata + homestay + riwayat pemesanan)
4. Dashboard Vendor (kelola wisata/homestay miliknya → CRUD)
5. Detail Wisata / Homestay + Form Pemesanan
6. Profil & Logout

**Use Case Diagram (singkat)** Aktor: Pengunjung, Vendor, (Admin tidak perlu) Use Case Pengunjung: Login, Register, Lihat Daftar Wisata, Pesan Tiket/Homestay, Lihat Riwayat Use Case Vendor: Login, Register, CRUD Wisata/Homestay miliknya, Lihat Pemesanan masuk

**Class Diagram (singkat)**
- User → Pengunjung, Vendor (inheritance)
- Wisata → atribut + method CRUD
- Homestay → atribut + method CRUD
- PemesananTiket, PemesananHomestay
## Ide 2 “PapuaCraft” – Marketplace Kerajinan Khas Papua (Noken, Ukiran Asmat, dll)

**2 Jenis Akun**
1. Pembeli
2. Pengrajin (penjual)

**Keunggulan**
- Tema budaya Papua sangat kuat
- Bisa foto-foto produk menarik di Figma
- CRUD produk oleh pengrajin

**Tabel** users, produk_kerajinan, keranjang, transaksi
## Ide 3 “PapuaGuide” – Platform Booking Tour Guide Lokal Papua

**2 Jenis Akun**
1. Wisatawan
2. Tour Guide Lokal

**Fitur**
- Wisatawan cari guide berdasarkan kabupaten, bahasa suku, rating
- Guide buat profil + jadwal available → CRUD

Sangat ringan backend-nya.
## Ide 4 “PapuaGuide” – Platform Booking Tour Guide Lokal Papua

**2 Jenis Akun**
1. Pengunjung
2. Panitia Event (misal Festival Baliem, Lembah Baliem)

**Fitur**
- Panitia buat event baru (CRUD)
- Pengunjung daftar event (jumlah peserta, dll)