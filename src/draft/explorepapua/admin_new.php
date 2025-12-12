<?php
require 'includes/db.php';
require 'functions/functions.php';

$extra_css = 'admin.css';
$hide_navbar = true;
$hide_footer = true;
include 'includes/header.php';

// Proteksi halaman admin
if(!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] != 'admin') { 
    header("Location: login.php"); 
    exit; 
}

// =============================================
// HANDLE CRUD OPERATIONS
// =============================================
$message = '';
$message_type = 'success'; // success, error, warning

// CREATE TOUR
if(isset($_POST['create_tour'])) {
    $result = createTour($_POST);
    if($result) {
        $message = "✅ Tour berhasil ditambahkan!";
    } else {
        $message = "❌ Gagal menambahkan tour!";
        $message_type = 'error';
    }
}

// UPDATE TOUR
if(isset($_POST['update_tour'])) {
    $id = (int) $_POST['tour_id'];
    $result = updateTour($id, $_POST);
    if($result) {
        $message = "✅ Tour berhasil diupdate!";
    } else {
        $message = "❌ Gagal mengupdate tour!";
        $message_type = 'error';
    }
}

// DELETE TOUR
if(isset($_POST['delete_tour'])) {
    $id = (int) $_POST['tour_id'];
    $result = deleteTour($id);
    if($result) {
        $message = "✅ Tour berhasil dihapus!";
    } else {
        $message = "❌ Gagal menghapus tour!";
        $message_type = 'error';
    }
}

// UPDATE ORDER STATUS
if(isset($_POST['update_order_status'])) {
    $invoice = $_POST['invoice_number'];
    $status = $_POST['status'];
    $result = updateOrderStatus($invoice, $status);
    if($result) {
        $message = "✅ Status pesanan berhasil diupdate!";
    } else {
        $message = "❌ Gagal mengupdate status!";
        $message_type = 'error';
    }
}

// DELETE ORDER
if(isset($_POST['delete_order'])) {
    $id = (int) $_POST['order_id'];
    $result = deleteOrder($id);
    if($result) {
        $message = "✅ Pesanan berhasil dihapus!";
    } else {
        $message = "❌ Gagal menghapus pesanan!";
        $message_type = 'error';
    }
}

// Ambil semua data
$income = getTotalIncome();
$total_orders = getTotalOrders();
$total_tours = getTotalTours();
$total_users = getTotalUsers('user');
$orders = getAllOrders();
$tours = query("SELECT * FROM tours WHERE is_active = 1 ORDER BY created_at DESC");
?>

<div class="admin-container">
    <aside class="sidebar">
        <div class="brand">
            <h2>Admin Panel</h2>
            <p>Explore Papua</p>
        </div>
        <ul class="menu">
            <li><a href="#" onclick="showSection('dashboard')" class="active" id="menu-dashboard">📊 Dashboard</a></li>
            <li><a href="#" onclick="showSection('tours')" id="menu-tours">🏝️ Kelola Paket Tour</a></li>
            <li><a href="#" onclick="showSection('orders')" id="menu-orders">📦 Kelola Pesanan</a></li>
            <li><a href="index.php" style="color:white">🏠 Lihat Website</a></li>
            <li class="logout"><a href="logout.php">🚪 Keluar</a></li>
        </ul>
    </aside>
    
    <main class="content">
        <header>
            <h2 id="pageTitle">Dashboard Overview</h2>
            <div class="admin-profile">
                <span><?= escape($_SESSION['name']) ?></span>
                <img src="https://ui-avatars.com/api/?name=Admin&background=006064&color=fff">
            </div>
        </header>

        <?php if($message): ?>
        <div class="alert alert-<?= $message_type ?>" style="margin-bottom: 20px; padding: 15px; border-radius: 8px; background: <?= $message_type == 'success' ? '#e8f5e9' : '#ffebee' ?>; color: <?= $message_type == 'success' ? '#2e7d32' : '#c62828' ?>;">
            <?= $message ?>
        </div>
        <?php endif; ?>

        <!-- ===== SECTION: DASHBOARD ===== -->
        <div id="dashboard" class="section active">
            <div class="stats-grid">
                <div class="card stat">
                    <h3>Total Pendapatan</h3>
                    <p class="number"><?= formatRupiah($income) ?></p>
                    <small>Dari pesanan yang sudah dibayar</small>
                </div>
                <div class="card stat">
                    <h3>Total Pesanan</h3>
                    <p class="number"><?= $total_orders ?></p>
                    <small>Pending: <?= getTotalOrders('pending') ?> | Paid: <?= getTotalOrders('paid') ?></small>
                </div>
                <div class="card stat">
                    <h3>Paket Wisata</h3>
                    <p class="number"><?= $total_tours ?></p>
                    <small>Paket aktif tersedia</small>
                </div>
                <div class="card stat">
                    <h3>Total Users</h3>
                    <p class="number"><?= $total_users ?></p>
                    <small>Member terdaftar</small>
                </div>
            </div>
            
            <div class="card" style="margin-top:20px;">
                <h3>Pesanan Terbaru</h3>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Invoice</th>
                            <th>Pemesan</th>
                            <th>Paket</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach(array_slice($orders, 0, 10) as $o): ?>
                        <tr>
                            <td><?= escape($o['invoice_number']) ?></td>
                            <td><?= escape($o['full_name']) ?></td>
                            <td><?= escape($o['tour_name']) ?></td>
                            <td><?= date('d M Y', strtotime($o['booking_date'])) ?></td>
                            <td><?= formatRupiah($o['total_price']) ?></td>
                            <td><span class="badge <?= $o['status'] ?>"><?= strtoupper($o['status']) ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ===== SECTION: KELOLA TOURS ===== -->
        <div id="tours" class="section" style="display: none;">
            <div class="section-header">
                <h3>Kelola Paket Wisata</h3>
                <button class="btn btn-primary" onclick="showModal('modalAddTour')">➕ Tambah Paket Baru</button>
            </div>
            
            <div class="card">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Paket</th>
                            <th>Lokasi</th>
                            <th>Tipe</th>
                            <th>Harga</th>
                            <th>Rating</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($tours as $t): ?>
                        <tr>
                            <td><?= $t['id'] ?></td>
                            <td><?= escape($t['name']) ?></td>
                            <td><?= escape($t['location']) ?></td>
                            <td><span class="badge-type"><?= escape($t['type']) ?></span></td>
                            <td><?= formatRupiah($t['price']) ?></td>
                            <td>⭐ <?= $t['rating'] ?></td>
                            <td class="action-buttons">
                                <button class="btn-edit" onclick='editTour(<?= json_encode($t) ?>)'>✏️ Edit</button>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus tour ini?')">
                                    <input type="hidden" name="tour_id" value="<?= $t['id'] ?>">
                                    <button type="submit" name="delete_tour" class="btn-delete">🗑️ Hapus</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ===== SECTION: KELOLA ORDERS ===== -->
        <div id="orders" class="section" style="display: none;">
            <h3>Kelola Pesanan</h3>
            
            <div class="card">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Invoice</th>
                            <th>Pemesan</th>
                            <th>Email</th>
                            <th>Paket</th>
                            <th>Tanggal</th>
                            <th>Pax</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($orders as $o): ?>
                        <tr>
                            <td><?= escape($o['invoice_number']) ?></td>
                            <td><?= escape($o['full_name']) ?></td>
                            <td><?= escape($o['email']) ?></td>
                            <td><?= escape($o['tour_name']) ?></td>
                            <td><?= date('d M Y', strtotime($o['booking_date'])) ?></td>
                            <td><?= $o['pax_count'] ?> orang</td>
                            <td><?= formatRupiah($o['total_price']) ?></td>
                            <td>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="invoice_number" value="<?= $o['invoice_number'] ?>">
                                    <select name="status" onchange="this.form.submit()" class="status-select">
                                        <option value="pending" <?= $o['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                        <option value="confirmed" <?= $o['status'] == 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                                        <option value="paid" <?= $o['status'] == 'paid' ? 'selected' : '' ?>>Paid</option>
                                        <option value="cancelled" <?= $o['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                    </select>
                                    <button type="submit" name="update_order_status" style="display:none;"></button>
                                </form>
                            </td>
                            <td>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')">
                                    <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
                                    <button type="submit" name="delete_order" class="btn-delete">🗑️</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</div>

<!-- ===== MODAL: TAMBAH TOUR ===== -->
<div id="modalAddTour" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('modalAddTour')">&times;</span>
        <h2>Tambah Paket Wisata Baru</h2>
        <form method="POST" class="form-tour">
            <div class="form-group">
                <label>Nama Paket *</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Lokasi *</label>
                    <input type="text" name="location" required>
                </div>
                <div class="form-group">
                    <label>Tipe *</label>
                    <select name="type" required>
                        <option value="Open Trip">Open Trip</option>
                        <option value="Private">Private</option>
                        <option value="Customized">Customized</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Harga (Rp) *</label>
                    <input type="number" name="price" required>
                </div>
                <div class="form-group">
                    <label>Rating (1-5) *</label>
                    <input type="number" step="0.1" min="1" max="5" name="rating" value="5.0" required>
                </div>
            </div>
            <div class="form-group">
                <label>URL Gambar *</label>
                <input type="text" name="image_url" placeholder="nama-file.jpg" required>
                <small>Upload file ke folder assets/img/ terlebih dahulu</small>
            </div>
            <div class="form-group">
                <label>Deskripsi *</label>
                <textarea name="description" rows="5" required></textarea>
            </div>
            <button type="submit" name="create_tour" class="btn btn-primary">Simpan Tour</button>
        </form>
    </div>
</div>

<!-- ===== MODAL: EDIT TOUR ===== -->
<div id="modalEditTour" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('modalEditTour')">&times;</span>
        <h2>Edit Paket Wisata</h2>
        <form method="POST" class="form-tour" id="formEditTour">
            <input type="hidden" name="tour_id" id="edit_tour_id">
            <div class="form-group">
                <label>Nama Paket *</label>
                <input type="text" name="name" id="edit_name" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Lokasi *</label>
                    <input type="text" name="location" id="edit_location" required>
                </div>
                <div class="form-group">
                    <label>Tipe *</label>
                    <select name="type" id="edit_type" required>
                        <option value="Open Trip">Open Trip</option>
                        <option value="Private">Private</option>
                        <option value="Customized">Customized</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Harga (Rp) *</label>
                    <input type="number" name="price" id="edit_price" required>
                </div>
                <div class="form-group">
                    <label>Rating (1-5) *</label>
                    <input type="number" step="0.1" min="1" max="5" name="rating" id="edit_rating" required>
                </div>
            </div>
            <div class="form-group">
                <label>URL Gambar</label>
                <input type="text" name="image_url" id="edit_image_url" placeholder="Kosongkan jika tidak ingin ganti">
            </div>
            <div class="form-group">
                <label>Deskripsi *</label>
                <textarea name="description" id="edit_description" rows="5" required></textarea>
            </div>
            <button type="submit" name="update_tour" class="btn btn-primary">Update Tour</button>
        </form>
    </div>
</div>

<script>
// Switch Section
function showSection(sectionName) {
    // Hide all sections
    document.querySelectorAll('.section').forEach(s => s.style.display = 'none');
    document.querySelectorAll('.menu a').forEach(m => m.classList.remove('active'));
    
    // Show selected section
    document.getElementById(sectionName).style.display = 'block';
    document.getElementById('menu-' + sectionName).classList.add('active');
    
    // Update page title
    const titles = {
        'dashboard': 'Dashboard Overview',
        'tours': 'Kelola Paket Wisata',
        'orders': 'Kelola Pesanan'
    };
    document.getElementById('pageTitle').innerText = titles[sectionName];
}

// Modal Functions
function showModal(modalId) {
    document.getElementById(modalId).style.display = 'block';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Edit Tour Function
function editTour(tour) {
    document.getElementById('edit_tour_id').value = tour.id;
    document.getElementById('edit_name').value = tour.name;
    document.getElementById('edit_location').value = tour.location;
    document.getElementById('edit_type').value = tour.type;
    document.getElementById('edit_price').value = tour.price;
    document.getElementById('edit_rating').value = tour.rating;
    document.getElementById('edit_image_url').value = '';
    document.getElementById('edit_description').value = tour.description;
    showModal('modalEditTour');
}

// Close modal when clicking outside
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
}
</script>

<style>
/* Additional Styles for Admin Features */
.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-primary {
    background: #006064;
    color: white;
}

.btn-primary:hover {
    background: #004d51;
    transform: translateY(-2px);
}

.btn-edit {
    background: #0288d1;
    color: white;
    padding: 6px 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-right: 5px;
}

.btn-delete {
    background: #d32f2f;
    color: white;
    padding: 6px 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.btn-edit:hover { background: #0277bd; }
.btn-delete:hover { background: #c62828; }

.action-buttons {
    display: flex;
    gap: 5px;
}

.badge-type {
    background: #e0f7fa;
    color: #006064;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 12px;
}

.status-select {
    padding: 6px 10px;
    border-radius: 4px;
    border: 1px solid #ddd;
    cursor: pointer;
}

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
    overflow-y: auto;
}

.modal-content {
    background-color: #fefefe;
    margin: 50px auto;
    padding: 30px;
    border-radius: 10px;
    width: 90%;
    max-width: 700px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.2);
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover { color: #000; }

.form-tour .form-group {
    margin-bottom: 20px;
}

.form-tour label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #333;
}

.form-tour input,
.form-tour select,
.form-tour textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 14px;
    box-sizing: border-box;
}

.form-tour textarea {
    resize: vertical;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}

.form-tour small {
    color: #666;
    font-size: 12px;
}

.alert {
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.stat small {
    display: block;
    margin-top: 10px;
    color: #666;
    font-size: 13px;
}
</style>

<?php include 'includes/footer.php'; ?>
