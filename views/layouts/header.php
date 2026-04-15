<?php
// Check session definition mostly for VSCode intelligence, handled in index.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
    <div class="container">
        <a href="index.php?page=home" class="logo">SARASI</a>
        <nav>
            <ul class="nav-links">
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <li><a href="index.php?page=home">Beranda</a></li>
                    <li><a href="index.php?page=login">Masuk</a></li>
                    <li><a href="index.php?page=register" class="btn btn-primary">Daftar</a></li>
                <?php else: ?>
                    <?php if ($_SESSION['role'] == 'siswa'): ?>
                        <li><a href="index.php?page=dashboard_siswa">Dashboard</a></li>
                        <li><a href="index.php?page=tulis_aspirasi">Tulis Aspirasi</a></li>
                    <?php else: ?>
                        <li><a href="index.php?page=dashboard_admin">Dashboard Admin</a></li>
                    <?php endif; ?>
                    <li><a href="index.php?page=logout" class="btn btn-outline">Keluar</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>
<main class="container">
