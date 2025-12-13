<?php
/**
 * File: functions.php
 * Berisi semua function CRUD untuk backend Explore Papua
 * Memenuhi kriteria: Implementasi function PHP dengan CRUD lengkap
 */

// Prevent duplicate inclusion
if (defined('FUNCTIONS_PHP_LOADED')) {
    return;
}
define('FUNCTIONS_PHP_LOADED', true);

// =============================================
// FUNCTION UNTUK TOURS (Paket Wisata)
// =============================================

/**
 * CREATE: Tambah tour baru
 */
function createTour($data) {
    global $conn;
    
    $name = mysqli_real_escape_string($conn, htmlspecialchars($data['name']));
    $location = mysqli_real_escape_string($conn, htmlspecialchars($data['location']));
    $type = mysqli_real_escape_string($conn, $data['type']);
    $price = (float) $data['price'];
    $image_url = mysqli_real_escape_string($conn, $data['image_url']);
    $description = mysqli_real_escape_string($conn, htmlspecialchars($data['description']));
    $rating = isset($data['rating']) ? (float) $data['rating'] : 5.0;
    
    $query = "INSERT INTO tours (name, location, type, price, image_url, description, rating) 
              VALUES ('$name', '$location', '$type', '$price', '$image_url', '$description', '$rating')";
    
    if(mysqli_query($conn, $query)) {
        return mysqli_insert_id($conn);
    }
    return false;
}

/**
 * READ: Ambil semua tours (dengan filter opsional)
 */
function getTours($filters = []) {
    global $conn;
    
    $where = ["is_active = 1"];
    
    if(isset($filters['location']) && !empty($filters['location'])) {
        $location = mysqli_real_escape_string($conn, $filters['location']);
        $where[] = "location = '$location'";
    }
    
    if(isset($filters['max_price']) && !empty($filters['max_price'])) {
        $max_price = (float) $filters['max_price'];
        $where[] = "price <= $max_price";
    }
    
    if(isset($filters['type']) && !empty($filters['type'])) {
        $type = mysqli_real_escape_string($conn, $filters['type']);
        $where[] = "type = '$type'";
    }
    
    $where_clause = implode(' AND ', $where);
    $query = "SELECT * FROM tours WHERE $where_clause ORDER BY rating DESC, created_at DESC";
    
    return query($query);
}

/**
 * READ: Ambil 1 tour berdasarkan ID
 */
function getTourById($id) {
    global $conn;
    $id = (int) $id;
    $result = query("SELECT * FROM tours WHERE id = $id AND is_active = 1");
    return count($result) > 0 ? $result[0] : null;
}

/**
 * UPDATE: Edit tour yang sudah ada
 */
function updateTour($id, $data) {
    global $conn;
    $id = (int) $id;
    
    $name = mysqli_real_escape_string($conn, htmlspecialchars($data['name']));
    $location = mysqli_real_escape_string($conn, htmlspecialchars($data['location']));
    $type = mysqli_real_escape_string($conn, $data['type']);
    $price = (float) $data['price'];
    $description = mysqli_real_escape_string($conn, htmlspecialchars($data['description']));
    $rating = (float) $data['rating'];
    
    // Jika ada image baru
    if(isset($data['image_url']) && !empty($data['image_url'])) {
        $image_url = mysqli_real_escape_string($conn, $data['image_url']);
        $query = "UPDATE tours SET 
                  name = '$name', 
                  location = '$location', 
                  type = '$type', 
                  price = '$price', 
                  image_url = '$image_url',
                  description = '$description', 
                  rating = '$rating'
                  WHERE id = $id";
    } else {
        $query = "UPDATE tours SET 
                  name = '$name', 
                  location = '$location', 
                  type = '$type', 
                  price = '$price', 
                  description = '$description', 
                  rating = '$rating'
                  WHERE id = $id";
    }
    
    return mysqli_query($conn, $query);
}

/**
 * DELETE: Soft delete tour (set is_active = 0)
 */
function deleteTour($id) {
    global $conn;
    $id = (int) $id;
    
    // Soft delete supaya data orders tetap valid
    $query = "UPDATE tours SET is_active = 0 WHERE id = $id";
    return mysqli_query($conn, $query);
}

/**
 * DELETE: Hard delete tour (hapus permanen)
 */
function hardDeleteTour($id) {
    global $conn;
    $id = (int) $id;
    
    // Cek apakah ada orders terkait
    $check = query("SELECT COUNT(*) as total FROM orders WHERE tour_id = $id");
    if($check[0]['total'] > 0) {
        return false; // Tidak bisa dihapus jika ada pesanan
    }
    
    $query = "DELETE FROM tours WHERE id = $id";
    return mysqli_query($conn, $query);
}

// =============================================
// FUNCTION UNTUK ORDERS (Pesanan)
// =============================================

/**
 * CREATE: Buat pesanan baru
 */
function createOrder($data) {
    global $conn;
    
    $invoice = 'INV-' . time();
    $user_id = (int) $data['user_id'];
    $tour_id = (int) $data['tour_id'];
    $booking_date = mysqli_real_escape_string($conn, $data['booking_date']);
    $pax_count = (int) $data['pax_count'];
    $total_price = (float) $data['total_price'];
    $ktp_file = isset($data['ktp_file']) ? mysqli_real_escape_string($conn, $data['ktp_file']) : 'ktp_dummy.jpg';
    
    $query = "INSERT INTO orders (invoice_number, user_id, tour_id, booking_date, pax_count, total_price, ktp_file, status) 
              VALUES ('$invoice', '$user_id', '$tour_id', '$booking_date', '$pax_count', '$total_price', '$ktp_file', 'pending')";
    
    if(mysqli_query($conn, $query)) {
        return $invoice;
    }
    return false;
}

/**
 * READ: Ambil orders user tertentu
 */
function getUserOrders($user_id) {
    $user_id = (int) $user_id;
    $query = "SELECT orders.*, tours.name as tour_name, tours.location, tours.image_url
              FROM orders 
              JOIN tours ON orders.tour_id = tours.id 
              WHERE user_id = $user_id 
              ORDER BY created_at DESC";
    return query($query);
}

/**
 * READ: Ambil semua orders (untuk admin)
 */
function getAllOrders() {
    $query = "SELECT orders.*, users.full_name, users.email, tours.name as tour_name 
              FROM orders 
              JOIN users ON orders.user_id = users.id 
              JOIN tours ON orders.tour_id = tours.id 
              ORDER BY created_at DESC";
    return query($query);
}

/**
 * READ: Ambil 1 order berdasarkan invoice
 */
function getOrderByInvoice($invoice) {
    global $conn;
    $invoice = mysqli_real_escape_string($conn, $invoice);
    $query = "SELECT orders.*, tours.name, tours.price, tours.location, users.full_name, users.email
              FROM orders 
              JOIN tours ON orders.tour_id = tours.id 
              JOIN users ON orders.user_id = users.id
              WHERE invoice_number = '$invoice'";
    $result = query($query);
    return count($result) > 0 ? $result[0] : null;
}

/**
 * UPDATE: Update status pesanan
 */
function updateOrderStatus($invoice, $status) {
    global $conn;
    $invoice = mysqli_real_escape_string($conn, $invoice);
    $allowed_status = ['pending', 'paid', 'cancelled', 'confirmed'];
    
    if(!in_array($status, $allowed_status)) {
        return false;
    }
    
    $query = "UPDATE orders SET status = '$status' WHERE invoice_number = '$invoice'";
    return mysqli_query($conn, $query);
}

/**
 * UPDATE: Update data order (tanggal, jumlah peserta)
 */
function updateOrder($id, $data) {
    global $conn;
    $id = (int) $id;
    
    $booking_date = mysqli_real_escape_string($conn, $data['booking_date']);
    $pax_count = (int) $data['pax_count'];
    $total_price = (float) $data['total_price'];
    
    $query = "UPDATE orders SET 
              booking_date = '$booking_date', 
              pax_count = '$pax_count', 
              total_price = '$total_price'
              WHERE id = $id";
    
    return mysqli_query($conn, $query);
}

/**
 * DELETE: Hapus order
 */
function deleteOrder($id) {
    global $conn;
    $id = (int) $id;
    
    $query = "DELETE FROM orders WHERE id = $id";
    return mysqli_query($conn, $query);
}

// =============================================
// FUNCTION UNTUK USERS
// =============================================

/**
 * READ: Ambil data user berdasarkan ID
 */
function getUserById($id) {
    $id = (int) $id;
    $result = query("SELECT id, full_name, email, role, created_at FROM users WHERE id = $id");
    return count($result) > 0 ? $result[0] : null;
}

/**
 * READ: Ambil semua users (untuk admin)
 */
function getAllUsers($role = null) {
    if($role) {
        global $conn;
        $role = mysqli_real_escape_string($conn, $role);
        return query("SELECT id, full_name, email, role, created_at FROM users WHERE role = '$role' ORDER BY created_at DESC");
    }
    return query("SELECT id, full_name, email, role, created_at FROM users ORDER BY created_at DESC");
}

/**
 * UPDATE: Update profile user
 */
function updateUserProfile($id, $data) {
    global $conn;
    $id = (int) $id;
    
    $full_name = mysqli_real_escape_string($conn, htmlspecialchars($data['full_name']));
    $email = mysqli_real_escape_string($conn, strtolower($data['email']));
    
    $query = "UPDATE users SET full_name = '$full_name', email = '$email' WHERE id = $id";
    return mysqli_query($conn, $query);
}

/**
 * DELETE: Hapus user (hati-hati dengan foreign key!)
 */
function deleteUser($id) {
    global $conn;
    $id = (int) $id;
    
    // Cek apakah user punya orders
    $check = query("SELECT COUNT(*) as total FROM orders WHERE user_id = $id");
    if($check[0]['total'] > 0) {
        return false; // Tidak bisa dihapus jika ada pesanan
    }
    
    $query = "DELETE FROM users WHERE id = $id AND role != 'admin'"; // Jangan hapus admin
    return mysqli_query($conn, $query);
}

// =============================================
// FUNCTION HELPER & VALIDASI
// =============================================

/**
 * Validasi tanggal booking (tidak boleh masa lalu)
 */
function validateBookingDate($date) {
    $booking = strtotime($date);
    $today = strtotime(date('Y-m-d'));
    return $booking >= $today;
}

/**
 * Sanitize output untuk mencegah XSS
 */
function escape($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Format rupiah
 */
function formatRupiah($angka) {
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

/**
 * Upload gambar tour
 */
function uploadTourImage($file) {
    $target_dir = "assets/img/";
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $max_size = 5 * 1024 * 1024; // 5MB
    
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    
    // Validasi
    if(!in_array($file_ext, $allowed_types)) {
        return ['success' => false, 'message' => 'Format file tidak didukung'];
    }
    
    if($file_size > $max_size) {
        return ['success' => false, 'message' => 'Ukuran file terlalu besar (max 5MB)'];
    }
    
    // Generate nama unik
    $new_name = 'tour_' . time() . '_' . uniqid() . '.' . $file_ext;
    $target_file = $target_dir . $new_name;
    
    if(move_uploaded_file($file_tmp, $target_file)) {
        return ['success' => true, 'filename' => $new_name];
    }
    
    return ['success' => false, 'message' => 'Gagal upload file'];
}

// =============================================
// FUNCTION UNTUK STATISTIK (ADMIN DASHBOARD)
// =============================================

/**
 * Ambil total pendapatan
 */
function getTotalIncome() {
    $result = query("SELECT SUM(total_price) as total FROM orders WHERE status = 'confirmed'");
    return $result[0]['total'] ?? 0;
}

/**
 * Ambil jumlah pesanan
 */
function getTotalOrders($status = null) {
    if($status) {
        global $conn;
        $status = mysqli_real_escape_string($conn, $status);
        $result = query("SELECT COUNT(*) as total FROM orders WHERE status = '$status'");
    } else {
        $result = query("SELECT COUNT(*) as total FROM orders");
    }
    return $result[0]['total'] ?? 0;
}

/**
 * Ambil jumlah tours aktif
 */
function getTotalTours() {
    $result = query("SELECT COUNT(*) as total FROM tours WHERE is_active = 1");
    return $result[0]['total'] ?? 0;
}

/**
 * Ambil jumlah users
 */
function getTotalUsers($role = null) {
    if($role) {
        global $conn;
        $role = mysqli_real_escape_string($conn, $role);
        $result = query("SELECT COUNT(*) as total FROM users WHERE role = '$role'");
    } else {
        $result = query("SELECT COUNT(*) as total FROM users");
    }
    return $result[0]['total'] ?? 0;
}

?>
