// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Get all product cards from PHP rendered HTML
    const allCards = Array.from(document.querySelectorAll('.product-card-horizontal'));

    // Extract data from cards for filtering
    const tourPackages = allCards.map(card => ({
        element: card,
        price: parseInt(card.getAttribute('data-price')),
        location: card.getAttribute('data-location')
    }));

    function filterData() {
        const priceRange = document.getElementById('priceRange');
        const locationCheckboxes = document.querySelectorAll('.location-filter');
        
        if (!priceRange) return;
        
        const maxPrice = parseInt(priceRange.value);
        const checkedLocations = Array.from(locationCheckboxes).filter(c => c.checked).map(c => c.value);
        
        let visibleCount = 0;
        
        tourPackages.forEach(pkg => {
            const matchPrice = pkg.price <= maxPrice;
            const matchLoc = checkedLocations.length === 0 || checkedLocations.some(loc => pkg.location.includes(loc));
            
            if (matchPrice && matchLoc) {
                pkg.element.style.display = 'flex';
                visibleCount++;
            } else {
                pkg.element.style.display = 'none';
            }
        });
        
        // Show "no results" message if needed
        const container = document.getElementById('resultContainer');
        let noResultsMsg = container.querySelector('.no-results-message');
        
        if (visibleCount === 0) {
            if (!noResultsMsg) {
                noResultsMsg = document.createElement('p');
                noResultsMsg.className = 'no-results-message';
                noResultsMsg.style.cssText = 'text-align:center; color: #666; font-size: 18px; padding: 50px;';
                noResultsMsg.textContent = 'Maaf, paket wisata tidak ditemukan.';
                container.appendChild(noResultsMsg);
            }
        } else {
            if (noResultsMsg) {
                noResultsMsg.remove();
            }
        }
    }

    const priceRange = document.getElementById('priceRange');
    const locationCheckboxes = document.querySelectorAll('.location-filter');

    if(priceRange) {
        priceRange.addEventListener('input', (e) => {
            document.getElementById('priceValue').innerText = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(e.target.value);
            filterData();
        });
    }
    
    locationCheckboxes.forEach(box => box.addEventListener('change', filterData));
});