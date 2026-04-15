<?php
session_start();
require_once 'config/database.php';

// Simple Router
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Base Layout
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SARASI - Pengaduan Sarana Sekolah</title>
    <link rel="stylesheet" href="public/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <?php
    // Basic Navigation
    if ($page != 'login' && $page != 'register') {
        include 'views/layouts/header.php';
    }

    // Routing Logic
    switch($page) {
        case 'home':
            include 'views/home.php';
            break;
        case 'login':
            include 'views/auth/login.php';
            break;
        case 'register':
            include 'views/auth/register.php';
            break;
        case 'logout':
            include 'auth/logout.php';
            break;
        
        // Student Routes
        case 'dashboard_siswa':
            include 'views/student/dashboard.php';
            break;
        case 'tulis_aspirasi':
            include 'views/student/form.php';
            break;
            
        // Admin Routes
        case 'dashboard_admin':
            include 'views/admin/dashboard.php';
            break;
        case 'aspirasi_detail':
            include 'views/admin/aspirasi_detail.php';
            break;
            
        default:
            echo "<div class='container'><h2>404 - Halaman Tidak Ditemukan</h2></div>";
            break;
    }

    if ($page != 'login' && $page != 'register') {
        include 'views/layouts/footer.php';
    }
    ?>

</body>
</html>
