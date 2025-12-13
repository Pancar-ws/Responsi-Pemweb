<?php if(!isset($hide_footer) || !$hide_footer): ?>
    <footer>
        <p>&copy; 2025 Explore Papua Project.</p>
    </footer>
    <?php endif; ?>

    <!-- Script Utama -->
    <script src="assets/js/script.js"></script>
    
    <!-- Script Navbar Mobile -->
    <script>
        const menuToggle = document.getElementById('mobile-menu');
        const navLinks = document.querySelector('.nav-links');
        if(menuToggle){
            menuToggle.addEventListener('click', () => {
                navLinks.classList.toggle('active');
            });
        }
    </script>
    
    <!-- Script Khusus Per Halaman -->
    <?php if(isset($extra_js)): ?>
        <script src="assets/js/<?= $extra_js ?>"></script>
    <?php endif; ?>
</body>
</html>