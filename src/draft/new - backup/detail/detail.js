const tourPackages = [
    { id: 1, name: "Eksotisme Raja Ampat", location: "Raja Ampat", type: "Open Trip", price: 5500000, image: "https://images.unsplash.com/photo-1516690561799-46d8f74f9abf?q=80&w=2070", desc: "Jelajahi surga bawah laut dunia di Raja Ampat. Paket ini mencakup kunjungan ke Wayag, Piaynemo, dan snorkeling.", rating: 5 },
    { id: 2, name: "Festival Lembah Baliem", location: "Wamena", type: "Private", price: 8500000, image: "https://upload.wikimedia.org/wikipedia/commons/thumb/6/6f/Baliem_Valley_Papua_Indonesia_1.jpg/1200px-Baliem_Valley_Papua_Indonesia_1.jpg", desc: "Saksikan kemeriahan festival budaya tertua di Papua.", rating: 5 },
    { id: 3, name: "Berenang dengan Hiu Paus", location: "Nabire", type: "Open Trip", price: 4200000, image: "https://indonesia.travel/content/dam/indtravelrevamp/en/destinations/maluku-papua/west-papua/cendrawasih-bay/header.jpg", desc: "Pengalaman langka berenang bersama raksasa laut yang lembut.", rating: 4 },
    { id: 4, name: "Raja Ampat Premium Dive", location: "Raja Ampat", type: "Private", price: 12000000, image: "https://images.unsplash.com/photo-1544551763-46a8723ba3f9?w=600", desc: "Nikmati kemewahan resort bintang 5.", rating: 5 }
];

function getQueryParam(param) { const urlParams = new URLSearchParams(window.location.search); return urlParams.get(param); }

window.addEventListener('load', () => {
    const tourId = getQueryParam('id');
    const tour = tourPackages.find(p => p.id === parseInt(tourId));
    if (tour) {
        document.title = `${tour.name} - Explore Papua`;
        document.getElementById('breadcrumbName').innerText = tour.name;
        document.getElementById('tourTitle').innerText = tour.name;
        document.getElementById('tourLocation').innerText = `📍 ${tour.location}`;
        document.getElementById('tourType').innerText = `🏷️ ${tour.type}`;
        document.getElementById('tourDesc').innerText = tour.desc;
        const formattedPrice = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(tour.price);
        document.getElementById('tourPrice').innerText = formattedPrice;
        document.getElementById('totalPrice').innerText = formattedPrice;
        document.getElementById('mainImg').src = tour.image;
        document.getElementById('tourPrice').dataset.value = tour.price;
    } else {
        document.querySelector('.main-content').innerHTML = "<h2>Paket tidak ditemukan :(</h2>";
    }
});

function changeImage(element) {
    document.getElementById('mainImg').src = element.src;
    document.querySelectorAll('.thumb').forEach(thumb => thumb.classList.remove('active'));
    element.classList.add('active');
}

function updateTotal() {
    const pricePerPax = parseInt(document.getElementById('tourPrice').dataset.value);
    const count = document.getElementById('paxCount').value;
    const total = pricePerPax * count;
    document.getElementById('totalPrice').innerText = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(total);
}

function handleBooking(event) {
    event.preventDefault();
    const tourName = document.getElementById('tourTitle').innerText;
    const paxInput = document.getElementById('paxCount').value;
    const dateInput = event.target.querySelector('input[type="date"]').value;
    const pricePerPax = parseInt(document.getElementById('tourPrice').dataset.value);
    const totalMath = pricePerPax * parseInt(paxInput);
    const totalFormatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(totalMath);

    const bookingData = { tourName: tourName, totalPrice: totalFormatted, pax: paxInput, date: dateInput, orderId: 'INV-' + Date.now() };
    localStorage.setItem('currentBooking', JSON.stringify(bookingData));

    const userSession = localStorage.getItem('userSession');
    if (userSession) {
        window.location.href = '../payment/payment.html';
    } else {
        alert("Silakan Login terlebih dahulu untuk melanjutkan.");
        window.location.href = '../login/login.html';
    }
}

const menuToggle = document.getElementById('mobile-menu');
const navLinks = document.querySelector('.nav-links');
if(menuToggle){ menuToggle.addEventListener('click', () => { navLinks.classList.toggle('active'); }); }