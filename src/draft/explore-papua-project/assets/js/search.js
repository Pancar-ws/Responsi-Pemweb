const tourPackages = [
    { id: 1, name: "Eksotisme Raja Ampat", location: "Raja Ampat", type: "Open Trip", price: 5500000, image: "assets/img/rajaampat.jpg", rating: 5 },
    { id: 2, name: "Festival Lembah Baliem", location: "Wamena", type: "Private", price: 8500000, image: "assets/img/wamena.jpeg", rating: 5 },
    { id: 3, name: "Berenang dengan Hiu Paus", location: "Nabire", type: "Open Trip", price: 4200000, image: "assets/img/nabire.jpg", rating: 4 },
    { id: 4, name: "Raja Ampat Premium Dive", location: "Raja Ampat", type: "Private", price: 12000000, image: "assets/img/dive.jpg", rating: 5 }
];

function renderPackages(data) {
    const container = document.getElementById('resultContainer');
    if (!container) return;
    container.innerHTML = '';
    if (data.length === 0) { container.innerHTML = '<p style="text-align:center;">Maaf, paket wisata tidak ditemukan.</p>'; return; }

    data.forEach(pkg => {
        const formattedPrice = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(pkg.price);
        const detailLink = `detail.html?id=${pkg.id}`;
        
        const html = `
            <div class="product-card-horizontal">
                <div class="product-img"><img src="${pkg.image}" alt="${pkg.name}"></div>
                <div class="product-details">
                    <div>
                        <h2 class="product-title">${pkg.name}</h2>
                        <p class="product-meta">📍 ${pkg.location} | ⭐ ${pkg.rating}/5 | 🏷️ ${pkg.type}</p>
                    </div>
                    <div class="product-footer">
                        <div class="product-price">${formattedPrice}</div>
                        <a href="${detailLink}" class="btn-book">Lihat Detail</a>
                    </div>
                </div>
            </div>`;
        container.innerHTML += html;
    });
}

window.addEventListener('load', () => {
    renderPackages(tourPackages);
    const priceRange = document.getElementById('priceRange');
    const locationCheckboxes = document.querySelectorAll('.location-filter');

    function filterData() {
        const maxPrice = priceRange.value;
        const checkedLocations = Array.from(locationCheckboxes).filter(c => c.checked).map(c => c.value);
        const filtered = tourPackages.filter(pkg => {
            const matchPrice = pkg.price <= maxPrice;
            const matchLoc = checkedLocations.length === 0 || checkedLocations.some(loc => pkg.location.includes(loc));
            return matchPrice && matchLoc;
        });
        renderPackages(filtered);
    }

    if(priceRange) priceRange.addEventListener('input', (e) => {
        document.getElementById('priceValue').innerText = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(e.target.value);
        filterData();
    });
    locationCheckboxes.forEach(box => box.addEventListener('change', filterData));
});