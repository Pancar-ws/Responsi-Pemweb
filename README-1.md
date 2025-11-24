# Laporan Riset Komprehensif: Strategi Pengembangan Sistem Informasi Berbasis Web dengan Tema "Papua" untuk Praktikum Informatika

## 1. Pendahuluan dan Analisis Situasional

### 1.1 Latar Belakang dan Konteks Akademik

Dalam lanskap pendidikan tinggi informatika, praktikum pengembangan web bukan sekadar latihan pengkodean, melainkan simulasi dinamika industri perangkat lunak yang sesungguhnya. Tantangan yang dihadapi oleh mahasiswa semester 3 dalam skenario ini—yakni pengembangan aplikasi berbasis proyek dengan tim yang tidak lengkap—merefleksikan kondisi nyata di lapangan di mana keterbatasan sumber daya manusia sering kali memaksa pengembang untuk merangkap peran (multitasking).

Anda dihadapkan pada situasi di mana sebuah tim yang idealnya terdiri dari tiga orang (Backend, Frontend, UI/UX) harus dijalankan oleh dua orang. Anda memegang peran ganda sebagai _Full Stack Developer_ (Backend dan Frontend), sementara rekan Anda berfokus pada UI/UX. Meskipun ini tampak sebagai beban kerja yang berat, ini sesungguhnya adalah peluang strategis untuk memastikan integrasi yang mulus antara logika bisnis (backend) dan antarmuka pengguna (frontend), meminimalisir miskomunikasi yang sering terjadi antara dua divisi tersebut.

Pemilihan tema "Papua" memberikan dimensi kedalaman yang luar biasa bagi proyek ini. Papua bukan hanya wilayah geografis, melainkan entitas sosio-ekonomi yang kaya dengan potensi pariwisata, komoditas unik, dan tantangan konservasi yang mendesak. Data menunjukkan bahwa Papua sedang mengalami transformasi digital dan ekonomi yang signifikan, didukung oleh inisiatif seperti Papua Youth Creative Hub (PYCH) yang bertujuan menstimulasi kreativitas pemuda.1 Oleh karena itu, aplikasi yang dibangun tidak boleh hanya sekadar "ada", melainkan harus mencerminkan solusi terhadap permasalahan atau potensi nyata di Papua.

### 1.2 Tujuan Laporan

Laporan ini disusun dengan ketelitian tinggi untuk memberikan panduan strategis dan teknis bagi tim Anda. Tujuannya adalah merumuskan ide proyek yang tidak hanya memenuhi rubrik penilaian akademis (CRUD, Session, Validasi Form, Desain Figma), tetapi juga memiliki relevansi kontekstual yang kuat dengan data terkini mengenai Papua. Laporan ini akan mengurai analisis data sekunder dari berbagai sektor di Papua, menerjemahkannya menjadi spesifikasi kebutuhan perangkat lunak, dan menyajikannya dalam kerangka kerja pengembangan sistem selama tiga minggu.

## 2. Analisis Tematik: Potensi Digital Papua

Untuk menentukan ide yang tepat, kita perlu membedah data empiris mengenai kondisi Papua saat ini. Aplikasi web yang baik adalah yang merespons data. Berikut adalah analisis mendalam terhadap sektor-sektor potensial.

### 2.1 Sektor Pariwisata dan Manajemen Acara

Data dari Badan Pusat Statistik (BPS) Provinsi Papua menunjukkan tren positif dalam sektor pariwisata. Pada November 2024, tercatat peningkatan kunjungan wisatawan mancanegara sebesar 4,41% dibandingkan bulan sebelumnya.3 Ini mengindikasikan bahwa minat global terhadap Papua terus tumbuh. Namun, pariwisata Papua memiliki karakteristik unik; ia sangat bergantung pada _event_ budaya dan wisata alam yang ekstrem.

Salah satu acara paling monumental adalah Festival Lembah Baliem. Informasi terkini menjadwalkan festival ini pada Agustus 2025 di distrik Wosilimo atau Wosiala, Jayawijaya.4 Festival ini menampilkan simulasi perang antar-suku, balap babi, dan pertunjukan musik tradisional Pikon. Kompleksitas acara ini—melibatkan ribuan prajurit suku Dani, Lani, dan Yali—menciptakan kebutuhan logistik yang masif.

Ide yang diusulkan oleh rekan tim Anda mengenai "Traveloka ala Papua" memiliki dasar yang kuat, namun cakupannya terlalu luas untuk tim beranggotakan dua orang. Traveloka menangani penerbangan, hotel, dan aktivitas secara global. Untuk praktikum ini, strategi terbaik adalah melakukan _scoping down_ (penyempitan lingkup) menjadi sistem manajemen tiket khusus untuk satu acara besar (niche market), seperti Festival Lembah Baliem. Ini memungkinkan penerapan fitur CRUD yang mendalam pada entitas "Tiket" dan "Peserta" tanpa terbebani kompleksitas integrasi API maskapai penerbangan.

### 2.2 Komoditas Unggulan dan Ekonomi Kreatif

Papua memiliki kekayaan agrikultur yang sering kali terhambat oleh akses pasar. Kopi Papua, khususnya varian Moanemani dari Kabupaten Dogiyai dan Arabika Wamena, memiliki reputasi internasional yang lebih tinggi dibandingkan popularitas domestiknya.7 Kopi ini ditanam secara organik oleh petani suku Mee dan memiliki profil rasa unik. Selain kopi, Batik Papua dengan motif Cendrawasih dan Tifa Honai juga menjadi komoditas budaya yang bernilai tinggi.9

Di sisi lain, Kabupaten Keerom diidentifikasi sebagai basis pengembangan jagung dengan luas lahan potensial mencapai 294.209 hektar.11 Namun, kesenjangan antara produsen di daerah terpencil (seperti Wamena atau Dogiyai) dengan pembeli di kota besar menciptakan peluang bagi platform _e-commerce_ spesialis.

Membangun _marketplace_ umum seperti Tokopedia terlalu ambisius. Namun, membangun platform "Direct-to-Consumer" untuk komoditas premium Papua adalah proyek yang sangat layak (feasible). Ini memenuhi syarat rubrik untuk "2 jenis akun berbeda" secara alami, yakni Akun Petani (Penjual) dan Akun Pembeli (Konsumen).

### 2.3 Konservasi Lingkungan dan "Green Tech"

Papua adalah rumah bagi keanekaragaman hayati laut terkaya di dunia, termasuk kawasan Kepala Burung (_Bird’s Head Seascape_) dan Raja Ampat.12 Namun, ekosistem ini terancam oleh praktik penangkapan ikan yang merusak seperti pemboman ikan.13 Organisasi seperti Yayasan Konservasi Alam Nusantara (YKAN) dan inisiatif global _Debt-for-Nature Swap_ senilai $35 juta menunjukkan besarnya arus pendanaan dan perhatian pada sektor ini.14

Terdapat tren global berupa "adopsi digital" untuk konservasi, di mana donatur dapat membiayai restorasi satu fragmen karang atau satu titik lokasi konservasi.16 Membuat aplikasi web yang memfasilitasi adopsi terumbu karang secara virtual adalah implementasi teknologi yang sangat relevan. Dari sisi teknis backend, ini melibatkan relasi database yang menarik antara entitas "Donatur", "Lokasi Terumbu", dan "Status Pertumbuhan", yang sangat cocok untuk mendemonstrasikan kemampuan CRUD yang kompleks.

### 2.4 Pendidikan dan Preservasi Bahasa

Tantangan sosial di Papua, terutama di daerah terisolasi, meliputi rendahnya kualitas pendidikan dan ancaman kepunahan bahasa daerah.18 Di daerah perkotaan seperti Jayapura, pendidikan berjalan lancar, namun di pedalaman, kehadiran guru dan materi ajar menjadi masalah. Selain itu, digitalisasi kamus bahasa daerah (seperti Bahasa Biak atau Sentani) menjadi urgensi tersendiri untuk pelestarian budaya.19

Aplikasi kamus kolaboratif (seperti Wikipedia untuk bahasa daerah) atau platform _e-learning_ sederhana dapat menjadi solusi. Ini memenuhi aspek "fungsi PHP" dengan fitur pencarian kata dan filter abjad, serta manajemen _session_ untuk kontributor data.

---

## 3. Rekomendasi Ide Proyek Terpilih

Berdasarkan analisis di atas, serta mempertimbangkan batasan waktu dan sumber daya (tim 2 orang), berikut adalah tiga rekomendasi ide proyek yang paling strategis. Setiap ide dirancang untuk memaksimalkan poin penilaian pada rubrik backend (CRUD, Session, Database Normalization) dan frontend/UI (Figma, Validasi Form).

### Ide 1: "PapuaBeans" – Platform Lelang & Penjualan Kopi Spesialti

**Konsep:** Sebuah web _marketplace_ tertutup (niche) yang menghubungkan petani kopi di Dogiyai dan Wamena langsung dengan _coffee roaster_ atau penikmat kopi premium. Fokusnya bukan pada kuantitas, melainkan pada ketelusuran (_traceability_) produk.

- **Relevansi:** Mengangkat komoditas Moanemani yang populer di luar negeri namun kurang akses pasar digital domestik.7
    
- **Kecocokan Tim:**
    
    - _Backend:_ Struktur database jelas (Produk, User, Transaksi). Logika bisnis berfokus pada manajemen stok dan status pesanan.
        
    - _UI/UX:_ Kesempatan eksplorasi visual dengan nuansa warna bumi (_earth tones_), tipografi etnik, dan fotografi makro biji kopi.
        

### Ide 2: "LembahPass" – Sistem E-Ticketing Festival Lembah Baliem

**Konsep:** Portal resmi pemesanan tiket dan paket wisata untuk Festival Lembah Baliem Agustus 2025. Menggantikan ide "Traveloka" yang terlalu luas dengan fokus pada manajemen kuota tiket acara dan izin fotografi.

- **Relevansi:** Merespons jadwal festival yang sudah pasti dan kebutuhan manajemen kerumunan.4
    
- **Kecocokan Tim:**
    
    - _Backend:_ Fokus pada validasi tanggal, pengurangan kuota tiket (concurrency), dan pembedaan hak akses antara Panitia dan Turis.
        
    - _UI/UX:_ Desain antarmuka yang meriah, menggunakan elemen visual perang suku dan pegunungan sebagai latar belakang.
        

### Ide 3: "ReefGuard Papua" – Platform Adopsi Terumbu Karang Digital

**Konsep:** Aplikasi penggalangan dana berbasis lokasi di mana pengguna dapat "mengadopsi" petak terumbu karang di Biak atau Raja Ampat yang rusak akibat bom ikan. Pengguna mendapatkan sertifikat digital dan pembaruan foto progres karang mereka.

- **Relevansi:** Mendukung upaya konservasi YKAN dan pemerintah dalam memulihkan ekosistem laut pasca-kerusakan.13
    
- **Kecocokan Tim:**
    
    - _Backend:_ CRUD digunakan untuk memantau status "hidup/mati" karang. Relasi database bersifat _One-to-Many_ (Satu User mengadopsi Banyak Karang).
        
    - _UI/UX:_ Penggunaan peta interaktif (bisa berupa gambar statis di Figma yang didesain seolah interaktif) dan visual bawah laut yang memukau.
        

---

## 4. Elaborasi Detail Teknis dan Desain

Bagian ini akan menguraikan secara mendalam spesifikasi teknis untuk ketiga ide di atas, meliputi User Activity, Class Diagram, dan Use Case Diagram. Ini adalah cetak biru yang akan Anda gunakan dalam pengembangan.

### 4.1 Ide Proyek A: "PapuaBeans" (E-Commerce Komoditas)

Proyek ini adalah implementasi klasik dari sistem manajemen inventaris yang dibalut antarmuka toko online. Ini adalah pilihan paling "aman" untuk memastikan semua kriteria rubrik terpenuhi dengan risiko teknis yang minim.

#### A.1 User Activity (Alur Aktivitas Pengguna)

Aktivitas pengguna dirancang untuk memisahkan secara tegas dua _role_ yang disyaratkan: Penjual (Petani/Koperasi) dan Pembeli.

1. **Fase Penemuan (Guest):** Pengguna tanpa akun mengakses halaman beranda. Mereka disuguhi _banner_ visual perkebunan kopi di Dogiyai. Mereka dapat melihat daftar produk (CRUD: _Read_) dengan filter berdasarkan asal (Wamena, Moanemani, Pegunungan Bintang).
    
2. **Fase Registrasi & Sesi:** Pengguna memutuskan membeli. Sistem meminta login. Jika belum punya akun, pengguna mendaftar. Di sinilah poin rubrik "2 jenis akun" dieksekusi: pada form registrasi terdapat _dropdown_ "Daftar Sebagai: Penikmat Kopi (Buyer) atau Petani (Seller)". Setelah login, sesi PHP (`$_SESSION`) menyimpan `user_id` dan `role`.
    
3. **Fase Transaksi (Buyer):** Pembeli memilih "Arabica Moanemani", memasukkan jumlah (kg), dan menekan tombol "Beli". Sistem memvalidasi stok. Jika cukup, data disimpan ke tabel `orders`.
    
4. **Fase Manajemen (Seller):** Di sisi lain, pengguna dengan _role_ Petani login. Mereka tidak melihat tombol "Beli", melainkan tombol "Tambah Produk" (CRUD: _Create_) dan "Kelola Pesanan". Petani dapat mengunggah foto biji kopi baru, mengubah harga (CRUD: _Update_), atau menghapus produk yang tidak panen (CRUD: _Delete_).
    

#### A.2 Class Diagram (Struktur Data & Logika)

Diagram kelas ini menggambarkan struktur tabel database dan representasi objek dalam kode PHP Anda.

|**Class / Table**|**Atribut (Kolom)**|**Method (Fungsi PHP)**|
|---|---|---|
|**User**|`userID` (PK, int), `username` (varchar), `password_hash` (varchar), `role` (enum: 'petani','pembeli'), `email` (varchar), `address` (text)|`registerUser()`, `loginUser()`, `checkSession()`|
|**Product**|`productID` (PK, int), `name` (varchar), `origin` (varchar), `process_type` (varchar), `price` (decimal), `stock` (int), `image_path` (varchar), `sellerID` (FK)|`addProduct()`, `updateProduct()`, `deleteProduct()`, `getProducts()`|
|**Order**|`orderID` (PK, int), `buyerID` (FK), `orderDate` (datetime), `totalAmount` (decimal), `status` (enum: 'pending','shipped')|`createOrder()`, `updateOrderStatus()`, `getUserOrders()`|

**Analisis Relasi:**

- **User (Petani) 1 -- * Product:** Satu petani dapat memiliki banyak produk (One-to-Many). Ini memenuhi syarat relasi tabel.
    
- **User (Pembeli) 1 -- * Order:** Satu pembeli dapat membuat banyak pesanan.
    
- **Product * -- * Order:** Relasi _Many-to-Many_ ini secara teknis membutuhkan tabel perantara (`OrderDetail`), namun untuk simplifikasi praktikum, Anda bisa menyimpan detail produk sebagai JSON string di tabel Order atau tetap menggunakan tabel `OrderDetail` untuk nilai maksimal.
    

#### A.3 Use Case Diagram (Interaksi Aktor)

- **Aktor: Pembeli**
    
    - _Browse Catalog_ (Melihat daftar kopi).
        
    - _Search Product_ (Mencari berdasarkan daerah).
        
    - _Add to Cart / Checkout_ (Membuat pesanan - _Create_).
        
    - _View Order History_ (Melihat riwayat - _Read_).
        
- **Aktor: Petani (Seller)**
    
    - _Manage Products_ (Mengelola produk - CRUD lengkap).
        
    - _Update Stock_ (Mengubah jumlah stok).
        
    - _Process Order_ (Mengubah status pesanan dari 'Pending' ke 'Sent').
        
- **System Boundary:** Mencakup otentikasi (Login/Logout) yang berlaku untuk kedua aktor.
    

---

### 4.2 Ide Proyek B: "LembahPass" (Ticketing Festival)

Ide ini lebih menantang secara logika validasi namun sangat kuat secara visual dan tema. Fokusnya adalah manajemen waktu dan kuota.

#### B.1 User Activity (Alur Aktivitas Pengguna)

1. **Eksplorasi Event:** Pengguna (Turis) mendarat di halaman utama yang menampilkan hitung mundur menuju Agustus 2025. Halaman ini berisi informasi jadwal perang suku dan balap babi.5
    
2. **Pemilihan Paket:** Turis memilih jenis tiket: "Day Pass" (Harian) atau "VIP Photographer Pass" (Akses ke tengah arena perang simulasi).
    
3. **Booking (Validasi Kompleks):** Saat Turis mengisi form pemesanan, sistem melakukan pengecekan ganda. Pertama, validasi input (form validation) untuk memastikan format email benar. Kedua, pengecekan backend untuk memastikan kuota tiket VIP masih tersedia.
    
4. **Administrasi:** Admin (Panitia Festival) memiliki dasbor khusus. Mereka melihat grafik penjualan tiket. Jika terjadi perubahan jadwal karena cuaca, Admin menggunakan fitur _Update_ untuk mengubah tanggal acara di database, yang otomatis terefleksi di halaman depan.
    

#### B.2 Class Diagram

|**Class / Table**|**Atribut (Kolom)**|**Method (Fungsi PHP)**|
|---|---|---|
|**Account**|`accountID` (PK), `email`, `password`, `accountType` ('admin', 'tourist')|`authLogin()`, `validateInput()`|
|**EventSchedule**|`scheduleID` (PK), `eventName` (e.g., 'Perang Suku'), `eventDate`, `quota_limit`, `current_bookings`|`updateSchedule()`, `checkAvailability()`|
|**TicketBooking**|`bookingID` (PK), `accountID` (FK), `scheduleID` (FK), `bookingTime`, `ticketCode` (unique)|`issueTicket()`, `cancelBooking()`|

Catatan Implementasi:

Pada tabel Account, Anda memisahkan data login. Untuk nilai tambah, Anda bisa membuat tabel terpisah bernama TouristProfile yang berisi data paspor/KTP (karena banyak turis asing ke Lembah Baliem), yang terhubung ke Account via Foreign Key. Ini menjawab tantangan "2 tabel untuk akun" dengan pendekatan normalisasi database.

#### B.3 Use Case Diagram

- **Aktor: Turis**
    
    - _View Festival Schedule_.
        
    - _Book Ticket_ (Pre-condition: Must be Logged In).
        
    - _Download E-Ticket_ (Menampilkan halaman HTML sederhana berisi kode tiket).
        
- **Aktor: Admin (Panitia)**
    
    - _Set Ticket Quota_ (Menentukan jumlah maksimal penonton demi keamanan).
        
    - _View Attendee List_ (Melihat siapa saja yang sudah booking).
        
    - _Edit Event Details_ (Mengubah deskripsi acara).
        

---

### 4.3 Ide Proyek C: "ReefGuard" (Konservasi Digital)

Proyek ini sangat unik karena menggabungkan elemen donasi dengan _monitoring_. Ini menonjolkan aspek UI/UX yang empatik.

#### C.1 User Activity (Alur Aktivitas Pengguna)

1. **Edukasi & Empati:** Halaman depan menampilkan fakta tentang kerusakan terumbu karang di Biak dan Supiori akibat bahan peledak.13
    
2. **Peta Adopsi:** Pengguna (Donatur) melihat representasi peta laut. Ada titik-titik merah (rusak) dan hijau (sudah diadopsi).
    
3. **Proses Adopsi:** Donatur mengklik titik merah, mengisi form donasi (validasi: nominal harus angka), dan mengirimkan data. Status titik tersebut berubah menjadi "Pending Payment" atau "Adopted" di database.
    
4. **Monitoring:** Pengguna dengan peran "Ranger" (Penjaga Laut) login. Mereka bertugas memverifikasi donasi dan secara berkala mengunggah foto perkembangan karang tersebut (Fitur _Update_ pada entitas Karang).
    

#### C.2 Class Diagram

|**Class / Table**|**Atribut (Kolom)**|**Method (Fungsi PHP)**|
|---|---|---|
|**Member**|`memberID` (PK), `fullName`, `email`, `password`, `role` ('donor', 'ranger')|`login()`, `register()`|
|**ReefSpot**|`spotID` (PK), `locationName` (e.g., 'Biak Sector A'), `coordinates`, `condition` ('damaged', 'recovering', 'healthy'), `photoURL`|`updateCondition()`, `uploadPhoto()`|
|**Adoption**|`adoptionID` (PK), `memberID` (FK), `spotID` (FK), `donationDate`, `amount`|`processAdoption()`|

Relasi Penting:

Relasi antara Adoption dan ReefSpot adalah One-to-One (dalam konteks satu periode adopsi) atau Many-to-One. Jika satu titik karang hanya boleh diadopsi satu orang, maka saat Adoption tercipta, status ReefSpot harus di-update agar tidak bisa dipilih orang lain. Logika ini sangat bagus untuk nilai pemrograman backend.

#### C.3 Use Case Diagram

- **Aktor: Donatur**
    
    - _Select Reef Location_.
        
    - _Donate/Adopt_ (Create Transaction).
        
    - _View Impact Report_ (Melihat foto progres karang).
        
- **Aktor: Ranger (Admin)**
    
    - _Add New Spot_ (Menambah lokasi baru yang butuh bantuan).
        
    - _Update Reef Status_ (Mengunggah foto terbaru).
        
    - _Validate Donation_.
        

---

## 5. Rencana Eksekusi Tiga Minggu (Strategi Agile Tim Kecil)

Mengingat tim hanya terdiri dari 2 orang (Anda sebagai _Full Stack_ dan Aqsha sebagai UI/UX), manajemen waktu adalah kunci. Kita akan menggunakan pendekatan _Agile_ yang dimodifikasi, di mana UI/UX bekerja satu langkah di depan pengembangan kode.

### Minggu 1: Fondasi, Desain, dan Database (25 Nov - 1 Des 2025)

**Fokus Utama:** Membekukan ide dan menyiapkan infrastruktur. Jangan mengubah ide setelah minggu ini berakhir.

- **Hari 1-2 (Senin-Selasa): Konseptualisasi & Setup**
    
    - **Anda (Full Stack):** Instalasi lingkungan kerja (XAMPP/Laragon, VS Code, Git). Buat repositori GitHub. Rancang skema database MySQL (seperti Class Diagram di atas) dan lakukan normalisasi tabel hingga bentuk normal ketiga (3NF) untuk memastikan efisiensi penyimpanan data.
        
    - **Aqsha (UI/UX):** Riset visual. Tentukan palet warna (misal: Coklat Kopi untuk _PapuaBeans_ atau Biru Laut untuk _ReefGuard_). Buat _Low-Fidelity Wireframe_ untuk 4 halaman utama: Login, Register, Dashboard Utama, Detail Item.
        
- **Hari 3-4 (Rabu-Kamis): Desain Hi-Fi & Struktur Kode**
    
    - **Aqsha (UI/UX):** Konversi wireframe menjadi _High-Fidelity Design_ di Figma. Pastikan penggunaan _Auto Layout_ untuk mendapatkan nilai tambah. Buat prototipe interaktif (klik tombol pindah halaman).
        
    - **Anda (Full Stack):** Mulai _coding_ struktur HTML dasar. Buat file koneksi database (`config.php` atau `db.php`).
        
- **Hari 5-7 (Jumat-Minggu): Sinkronisasi Awal**
    
    - Review desain Figma. Pastikan desain tersebut _bisa_ diimplementasikan dengan CSS/Bootstrap/Tailwind dalam waktu singkat. Jika desain terlalu rumit (banyak animasi), minta Aqsha sederhanakan.
        
    - Buat tabel database di phpMyAdmin.
        

### Minggu 2: Pengembangan Inti Backend & Integrasi (2 Des - 8 Des 2025)

**Fokus Utama:** Fungsionalitas CRUD dan Login (Poin penilaian terbesar ada di sini).

- **Hari 1-3 (Senin-Rabu): Otentikasi & Session**
    
    - **Anda (Full Stack):** Implementasi fitur Login dan Register.
        
        - Gunakan `password_hash()` untuk keamanan (nilai plus).
            
        - Implementasi `session_start()` di setiap halaman.
            
        - Buat logika _Role-Based Access Control_: `if ($_SESSION['role']!== 'admin') { header("Location: index.php"); }`. Ini krusial untuk poin "2 jenis akun".
            
    - **Aqsha (UI/UX):** Mulai menyusun "Design System" (dokumentasi font, warna, komponen tombol) untuk laporan akhir, sembari membantu _slice_ aset gambar untuk Anda.
        
- **Hari 4-6 (Kamis-Sabtu): CRUD Implementation**
    
    - **Anda (Full Stack):** Fokus pada fitur inti.
        
        - _Create:_ Form tambah data (produk/tiket/karang) dengan upload gambar (`move_uploaded_file`).
            
        - _Read:_ Tampilkan data dari database ke tabel HTML atau kartu grid (`mysqli_fetch_assoc`).
            
        - _Update/Delete:_ Buat tombol edit dan hapus yang melewatkan ID via URL (`delete.php?id=5`).
            
    - Tips: Fokuskan fungsi dulu, tampilan bisa diperbaiki belakangan.
        
- **Hari 7 (Minggu): Integrasi Frontend**
    
    - Mulai terapkan CSS pada halaman-halaman PHP yang sudah berfungsi. Pastikan tampilannya mendekati desain Figma Aqsha.
        

### Minggu 3: Penyempurnaan, Validasi, dan Finishing (9 Des - 15 Des 2025)

**Fokus Utama:** Detail kecil yang bernilai poin (Validasi, Fungsi PHP) dan presentasi.

- **Hari 1-2 (Senin-Selasa): Validasi Form & Fungsi PHP**
    
    - **Anda (Full Stack):** Tambahkan validasi.
        
        - _Frontend:_ Gunakan atribut HTML5 `required`, `type="email"`, `min="0"`. Tambahkan sedikit JavaScript untuk pesan error yang dinamis.
            
        - _Backend:_ Buat 2 Fungsi PHP sesuai rubrik. Contoh: `function formatRupiah($angka)` untuk harga, dan `function cleanInput($data)` untuk keamanan _input_ (mencegah XSS/SQL Injection).
            
- **Hari 3-4 (Rabu-Kamis): Quality Assurance (QA)**
    
    - Lakukan uji coba lintas akun. Login sebagai Admin, coba akses halaman user biasa, dan sebaliknya. Pastikan tidak ada celah keamanan sesi.
        
    - Cek responsivitas tampilan (Mobile vs Desktop).
        
- **Hari 5-6 (Jumat-Sabtu): Dokumentasi & Laporan**
    
    - **Aqsha (UI/UX):** Finalisasi file Figma, pastikan semua _frame_ tertata rapi. Export _assets_ wireframe dan prototipe untuk laporan.
        
    - **Bersama:** Susun laporan praktikum. Jelaskan diagram kelas dan alur _user_ yang telah dibuat.
        
- **Hari 7 (Minggu): Final Submission**
    
    - Cek ulang seluruh rubrik penilaian satu per satu. Pastikan tidak ada poin yang terlewat.
        

---

## 6. Analisis Teknis Mendalam: Strategi Implementasi Kode

Untuk memastikan Anda mendapatkan nilai maksimal dengan tim minimal, berikut adalah strategi teknis spesifik untuk aspek Backend dan Frontend.

### 6.1 Strategi Backend (PHP Native yang Efisien)

Karena Anda menangani backend sendirian, hindari kerumitan _framework_ berat jika tidak diwajibkan. Gunakan pola prosedural yang terstruktur atau _Object-Oriented_ sederhana.

- **Manajemen Sesi dan Keamanan:** Rubrik meminta implementasi sesi. Jangan hanya sekadar login. Terapkan `session_regenerate_id()` setiap kali user login untuk mencegah _Session Fixation_. Ini menunjukkan pemahaman mendalam.
    
- **Pemisahan Logika:** Meskipun tidak menggunakan framework, pisahkan logika koneksi database ke file `db.php`. Include file ini di setiap halaman. Ini memudahkan jika Anda perlu mengubah password database nanti.
    
- **Implementasi 2 Fungsi PHP:**
    
    - Fungsi 1: Logika Bisnis. Misal pada proyek Kopi: `function hitungDiskon($totalBelanja, $roleUser)`. Jika _role_-nya 'Member Premium', beri diskon.
        
    - Fungsi 2: Utilitas Tampilan. Misal: `function statusBadge($status)`. Jika status 'Pending', return HTML span berwarna kuning; jika 'Success', warna hijau.
        

### 6.2 Strategi Frontend & UI/UX (Konsistensi Desain)

Tantangan terbesar adalah menerjemahkan desain Figma ke kode CSS sendirian.

- **Gunakan CSS Variables:** Definisikan warna-warna Papua (Merah Tanah, Hitam, Kuning Cendrawasih) di `:root` CSS.
    
    CSS
    
    ```
    :root {
        --primary-color: #8B4513; /* Warna Kopi */
        --accent-color: #FFD700; /* Kuning Cendrawasih */
    }
    ```
    
    Ini selaras dengan syarat "Design System" dari peran UI/UX.
    
- **Komponen yang Dapat Digunakan Kembali:** Buat satu desain "Kartu Produk" (Card) yang bagus di CSS, lalu gunakan struktur HTML yang sama untuk semua daftar item. Jangan mendesain ulang setiap halaman dari nol.
    
- **Aset Visual:** Gunakan pola Batik Papua 22 sebagai latar belakang _body_ atau _header_ secara halus (_opacity_ rendah). Ini memberikan identitas visual yang kuat tanpa perlu banyak elemen grafis berat.
    

## 7. Kesimpulan

Meskipun tim Anda hanya terdiri dari dua orang, struktur proyek ini telah dirancang untuk mengubah keterbatasan tersebut menjadi keunggulan efisiensi. Dengan memilih salah satu dari tiga ide yang direkomendasikan—terutama **"PapuaBeans" (E-Commerce Kopi)** atau **"LembahPass" (Ticketing Festival)**—Anda dapat memenuhi seluruh kriteria penilaian (CRUD, Session, Multi-role, Validasi, Desain Figma) secara komprehensif.

Kunci keberhasilan proyek ini terletak pada **disiplin lingkup kerja** (_scope discipline_). Jangan tergoda untuk menambahkan fitur canggih seperti pembayaran _real-time_ atau pelacakan peta GPS langsung jika fitur dasar CRUD belum sempurna. Fokuslah pada penyelesaian rubrik akademik terlebih dahulu dengan kualitas kode yang rapi dan desain antarmuka yang konsisten dan merefleksikan identitas Papua.

Strategi tiga minggu yang dipaparkan di atas memberikan jalur yang jelas: Minggu pertama untuk desain dan data, minggu kedua untuk logika backend yang berat, dan minggu ketiga untuk penyempurnaan antarmuka dan validasi. Dengan mengikuti peta jalan ini, Anda dan rekan Anda berada dalam posisi yang sangat baik untuk tidak hanya lulus praktikum ini, tetapi juga menghasilkan portofolio yang membanggakan.