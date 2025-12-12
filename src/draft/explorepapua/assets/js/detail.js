// Function to change gallery image
function changeImage(element) {
    const mainImg = document.getElementById('mainImg');
    if (mainImg) {
        mainImg.src = element.src;
    }
    document.querySelectorAll('.thumb').forEach(thumb => thumb.classList.remove('active'));
    element.classList.add('active');
}

// Function to update total price based on passenger count
function updateTotal() {
    const tourPriceElement = document.getElementById('tourPrice');
    const paxCountElement = document.getElementById('paxCount');
    const totalPriceElement = document.getElementById('totalPrice');
    
    if (!tourPriceElement || !paxCountElement || !totalPriceElement) {
        return;
    }
    
    const pricePerPax = parseInt(tourPriceElement.getAttribute('data-value'));
    const count = parseInt(paxCountElement.value) || 1;
    const total = pricePerPax * count;
    
    const formattedTotal = new Intl.NumberFormat('id-ID', { 
        style: 'currency', 
        currency: 'IDR', 
        minimumFractionDigits: 0 
    }).format(total);
    
    totalPriceElement.innerText = formattedTotal;
}

// Function to handle booking form submission
function handleBooking(event) {
    event.preventDefault();
    
    const tourName = document.getElementById('tourTitle').innerText;
    const paxInput = document.getElementById('paxCount').value;
    const dateInput = event.target.querySelector('input[type="date"]').value;
    const nameInput = event.target.querySelector('input[type="text"]').value;
    const pricePerPax = parseInt(document.getElementById('tourPrice').getAttribute('data-value'));
    const totalMath = pricePerPax * parseInt(paxInput);
    const totalFormatted = new Intl.NumberFormat('id-ID', { 
        style: 'currency', 
        currency: 'IDR', 
        minimumFractionDigits: 0 
    }).format(totalMath);

    const bookingData = { 
        tourName: tourName, 
        totalPrice: totalFormatted, 
        pax: paxInput, 
        date: dateInput,
        name: nameInput,
        orderId: 'INV-' + Date.now() 
    };
    
    localStorage.setItem('currentBooking', JSON.stringify(bookingData));
    window.location.href = 'payment.php';
}

// Initialize when DOM is loaded
window.addEventListener('load', function() {
    const paxInput = document.getElementById('paxCount');
    if (paxInput) {
        // Add event listeners for real-time update
        paxInput.addEventListener('input', updateTotal);
        paxInput.addEventListener('change', updateTotal);
    }
});