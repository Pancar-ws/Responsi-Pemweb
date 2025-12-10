function switchTab(tab) {
    const loginBox = document.getElementById('form-login-box');
    const regBox = document.getElementById('form-register-box');
    const btnLogin = document.getElementById('tab-login');
    const btnReg = document.getElementById('tab-register');

    if (tab === 'login') {
        loginBox.style.display = 'block';
        regBox.style.display = 'none';
        btnLogin.classList.add('active');
        btnReg.classList.remove('active');
    } else {
        loginBox.style.display = 'none';
        regBox.style.display = 'block';
        btnLogin.classList.remove('active');
        btnReg.classList.add('active');
    }
}

function handleLogin(event) {
    event.preventDefault();
    const email = event.target.querySelector('input[type="email"]').value;
    const password = event.target.querySelector('input[type="password"]').value;

    if(email && password) {
        const btn = document.querySelector('.btn-full');
        btn.innerText = "Memproses...";
        
        setTimeout(() => {
            const userData = { name: "User Demo", email: email, isLoggedIn: true };
            localStorage.setItem('userSession', JSON.stringify(userData));
            alert("Login Berhasil!");
            const pendingBooking = localStorage.getItem('currentBooking');
            if (pendingBooking) {
                window.location.href = '../payment/index.html';
            } else {
                window.location.href = '../home/index.html';
            }
        }, 1000);
    } else {
        alert("Mohon lengkapi data!");
    }
}

function handleRegister(event) {
    event.preventDefault();
    const name = document.getElementById('reg-name').value;
    const pass = document.getElementById('reg-pass').value;
    const confirm = document.getElementById('reg-confirm').value;

    if (pass !== confirm) { alert("Konfirmasi password tidak cocok!"); return; }

    const btn = document.querySelector('.btn-register');
    btn.innerText = "Mendaftarkan...";

    setTimeout(() => {
        alert(`Pendaftaran Berhasil! Selamat datang, ${name}. Silakan login.`);
        switchTab('login');
        event.target.reset();
        btn.innerText = "Daftar Akun";
    }, 1500);
}