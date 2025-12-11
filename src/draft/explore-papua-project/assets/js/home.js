const navbar = document.getElementById('navbar');
const menuToggle = document.getElementById('mobile-menu');
const navLinks = document.querySelector('.nav-links');

window.onscroll = function() {
    if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
};

if(menuToggle){
    menuToggle.addEventListener('click', () => {
        navLinks.classList.toggle('active');
    });
}