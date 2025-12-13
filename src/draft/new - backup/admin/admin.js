const toursData = [
    { id: 1, name: "Eksotisme Raja Ampat", loc: "Raja Ampat", price: "Rp 5.500.000" },
    { id: 2, name: "Festival Lembah Baliem", loc: "Wamena", price: "Rp 8.500.000" },
    { id: 3, name: "Berenang dengan Hiu Paus", loc: "Nabire", price: "Rp 4.200.000" },
    { id: 4, name: "Raja Ampat Premium Dive", loc: "Raja Ampat", price: "Rp 12.000.000" }
];

const ordersData = [
    { id: "INV-001", user: "Sarah Wijaya", tour: "Eksotisme Raja Ampat", date: "2025-05-12", status: "paid" },
    { id: "INV-002", user: "Budi Santoso", tour: "Lembah Baliem", date: "2025-06-20", status: "pending" },
    { id: "INV-003", user: "Andi Pratama", tour: "Hiu Paus Nabire", date: "2025-07-01", status: "paid" }
];

function renderTours() {
    const tbody = document.getElementById('tourTableBody');
    tbody.innerHTML = '';
    toursData.forEach(tour => {
        const row = `<tr><td>#${tour.id}</td><td><b>${tour.name}</b></td><td>${tour.loc}</td><td>${tour.price}</td><td><button class="btn-sm edit">✏ Edit</button><button class="btn-sm delete">🗑 Hapus</button></td></tr>`;
        tbody.innerHTML += row;
    });
}

function renderOrders() {
    const tbody = document.getElementById('orderTableBody');
    tbody.innerHTML = '';
    ordersData.forEach(order => {
        let badgeClass = order.status === 'paid' ? 'paid' : 'pending';
        let statusText = order.status === 'paid' ? 'Lunas' : 'Menunggu';
        const row = `<tr><td>${order.id}</td><td>${order.user}</td><td>${order.tour}</td><td>${order.date}</td><td><span class="badge ${badgeClass}">${statusText}</span></td><td><button class="btn-sm edit">👁 Detail</button></td></tr>`;
        tbody.innerHTML += row;
    });
}

function showSection(sectionId, element) {
    document.querySelectorAll('.section').forEach(sec => sec.style.display = 'none');
    document.getElementById(sectionId).style.display = 'block';
    document.getElementById('pageTitle').innerText = { 'dashboard': 'Dashboard Overview', 'tours': 'Kelola Paket Wisata', 'orders': 'Daftar Pesanan Masuk' }[sectionId];
    document.querySelectorAll('.menu li').forEach(li => li.classList.remove('active'));
    element.classList.add('active');
}

window.addEventListener('load', () => { renderTours(); renderOrders(); });