window.addEventListener('load', () => {
    const dataString = localStorage.getItem('currentBooking');
    if (!dataString) { alert("Belum ada pesanan!"); window.location.href = 'home.html'; return; }
    const booking = JSON.parse(dataString);
    document.getElementById('displayId').innerText = booking.orderId;
    document.getElementById('displayName').innerText = booking.tourName;
    document.getElementById('displayDate').innerText = booking.date;
    document.getElementById('displayPax').innerText = booking.pax + " Orang";
    document.getElementById('displayTotal').innerText = booking.totalPrice;
    
    const now = new Date(); now.setHours(now.getHours() + 1);
    document.getElementById('deadlineTime').innerText = now.toLocaleDateString('id-ID', { hour: '2-digit', minute: '2-digit', day: 'numeric', month: 'short' });
    startTimer(3600);
});

function startTimer(duration) {
    let timer = duration, hours, minutes, seconds;
    const display = document.getElementById('countdown');
    setInterval(() => {
        hours = parseInt(timer / 3600, 10); minutes = parseInt((timer % 3600) / 60, 10); seconds = parseInt(timer % 60, 10);
        display.textContent = (hours < 10 ? "0" + hours : hours) + ":" + (minutes < 10 ? "0" + minutes : minutes) + ":" + (seconds < 10 ? "0" + seconds : seconds);
        if (--timer < 0) timer = 0;
    }, 1000);
}

function copyText(elementId) {
    navigator.clipboard.writeText(document.getElementById(elementId).innerText).then(() => alert("Disalin!"));
}

function finishPayment() {
    alert("Pembayaran Terkonfirmasi!");
    window.location.href = 'dashboard.html';
}