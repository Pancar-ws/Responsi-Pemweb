window.addEventListener('load', () => {
    // Set deadline time (30 minutes from now)
    const now = new Date();
    now.setMinutes(now.getMinutes() + 30);
    document.getElementById('deadlineTime').innerText = now.toLocaleDateString('id-ID', {
        hour: '2-digit',
        minute: '2-digit',
        day: 'numeric',
        month: 'short'
    });
    
    // Start countdown timer (30 minutes = 1800 seconds)
    startTimer(1800);
});

function startTimer(duration) {
    let timer = duration;
    const display = document.getElementById('countdown');
    
    setInterval(() => {
        let minutes = parseInt(timer / 60, 10);
        let seconds = parseInt(timer % 60, 10);
        
        display.textContent = 
            (minutes < 10 ? "0" + minutes : minutes) + ":" +
            (seconds < 10 ? "0" + seconds : seconds);
        
        if (--timer < 0) {
            timer = 0;
        }
    }, 1000);
}

function copyText(elementId) {
    const text = document.getElementById(elementId).innerText;
    navigator.clipboard.writeText(text).then(() => {
        alert("Nomor rekening disalin!");
    });
}

function finishPayment() {
    // Kirim request untuk update status ke PAID
    fetch('payment.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'confirm_payment=1'
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            alert("Pembayaran Terkonfirmasi! Status pesanan Anda telah diubah menjadi PAID. Silakan tunggu verifikasi dari admin.");
            window.location.href = 'dashboard.php';
        } else {
            alert("Terjadi kesalahan. Silakan coba lagi.");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("Terjadi kesalahan koneksi. Silakan coba lagi.");
    });
}