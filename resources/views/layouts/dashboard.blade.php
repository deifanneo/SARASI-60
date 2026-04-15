<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | SARASI Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #1e3a5f;
            --dark-blue: #152a45;
            --sidebar-width: 260px;
            --accent-green: #4CAF50;
            --light-green: #e8f5e9;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
        }

        /* Sidebar Styling */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background-color: var(--primary-blue);
            color: white;
            z-index: 1000;
            transition: all 0.3s;
            border-right: 1px solid rgba(255,255,255,0.05);
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            text-align: center;
            background: linear-gradient(to bottom, var(--dark-blue), var(--primary-blue));
        }

        .nav-link {
            color: rgba(255,255,255,0.65);
            padding: 0.9rem 1.5rem;
            font-weight: 500;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            border-left: 4px solid transparent;
        }

        .nav-link:hover {
            color: white;
            background-color: rgba(255,255,255,0.05);
        }

        .nav-link.active {
            color: white;
            background-color: rgba(255,255,255,0.1);
            border-left-color: var(--accent-green);
        }

        .nav-link i {
            margin-right: 12px;
            font-size: 1.25rem;
        }

        /* Design Polish Improvements */
        .card {
            border: none;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border-radius: 12px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .main-content {
            margin-left: var(--sidebar-width);
            padding: 1rem 2rem;
            min-height: 100vh;
            transition: all 0.3s;
        }

        .navbar-custom {
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            padding: 0.75rem 2rem;
            margin-bottom: 1rem;
            position: sticky;
            top: 0;
            z-index: 999;
            margin-left: var(--sidebar-width);
            border-bottom: 1px solid #e5e7eb;
            transition: all 0.3s;
        }

        .badge {
            padding: 0.6em 1em;
            font-weight: 700;
            font-size: 0.75rem;
            border-radius: 8px;
            letter-spacing: 0.025em;
        }

        .bg-indigo { background-color: #6366f1; }
        .bg-teal { background-color: #14b8a6; }

        .btn {
            border-radius: 10px;
            font-weight: 600;
            padding: 0.6rem 1.2rem;
            transition: all 0.2s;
        }

        .btn-primary { background-color: var(--primary-blue); border-color: var(--primary-blue); }
        .btn-primary:hover { background-color: var(--dark-blue); border-color: var(--dark-blue); }

        .sidebar .nav-link.logout-btn {
            margin: 1rem 1rem;
            padding: 0.75rem 1rem;
            background-color: rgba(220, 38, 38, 0.1);
            color: #fca5a5;
            border-radius: 10px;
            border: 1px solid rgba(220, 38, 38, 0.2);
        }

        .sidebar .nav-link.logout-btn:hover {
            background-color: #dc2626;
            color: white;
        }

        .table thead th {
            background-color: #f8fafc;
            text-transform: uppercase;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            color: #64748b;
            border-bottom: 1px solid #e2e8f0;
        }

        /* Simplify SweetAlert Animation (No Wobble) */
        .swal2-popup.swal2-show {
            animation: fadeIn 0.2s ease-out !important;
        }
        .swal2-toast.swal2-show {
            animation: fadeInRight 0.3s ease-out !important;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @media (max-width: 991.98px) {
            .sidebar { margin-left: calc(-1 * var(--sidebar-width)); }
            .sidebar.active { margin-left: 0; }
            .main-content, .navbar-custom { margin-left: 0 !important; }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar shadow d-flex flex-column" id="sidebar">
        <div class="sidebar-header">
            <div class="bg-white p-2 d-inline-block mb-2 rounded-3 shadow-sm">
                <img src="{{ asset('logo-sarasi.png') }}" alt="Logo" style="width: 60px; height: 60px; object-fit: contain;">
            </div>
            <h4 class="mb-0 fw-bold">SARASI</h4>
            <p class="small text-white-50 mb-0">Portal Aspirasi</p>
        </div>
        <div class="nav flex-column flex-grow-1 mt-4">
            <div class="px-4 mb-2 small text-white-50 text-uppercase tracking-wider fw-bold" style="font-size: 0.65rem;">Navigasi Utama</div>
            
            @if(session('role') == 'admin')
                <a href="/dashboard-admin" class="nav-link {{ request()->is('dashboard-admin') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="/admin/aspirasi" class="nav-link {{ request()->is('admin/aspirasi*') ? 'active' : '' }}">
                    <i class="bi bi-journal-text"></i> Semua Aspirasi
                </a>
                <a href="/admin/kategori" class="nav-link {{ request()->is('admin/kategori*') ? 'active' : '' }}">
                    <i class="bi bi-tag-fill"></i> Kategori
                </a>
                <a href="/admin/siswa" class="nav-link {{ request()->is('admin/siswa*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i> Data Siswa
                </a>
            @else
                <a href="/dashboard-siswa" class="nav-link {{ request()->is('dashboard-siswa') ? 'active' : '' }}">
                    <i class="bi bi-house-door-fill"></i> Dashboard Saya
                </a>
                <a href="/siswa/aspirasi/create" class="nav-link {{ request()->is('siswa/aspirasi/create') ? 'active' : '' }}">
                    <i class="bi bi-plus-circle-fill"></i> Buat Aspirasi
                </a>
            @endif
            
            <div class="mt-auto mb-4">
                <a href="/logout" class="nav-link logout-btn">
                    <i class="bi bi-box-arrow-right"></i> Keluar Sistem
                </a>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <button class="btn d-lg-none" type="button" onclick="document.getElementById('sidebar').classList.toggle('active')">
                <i class="bi bi-list"></i>
            </button>
            <div class="ms-auto d-flex align-items-center">
                <span class="me-3 d-none d-sm-inline">{{ session('nama') }} ({{ ucfirst(session('role')) }})</span>
                <div class="dropdown">
                    <button class="btn btn-light rounded-circle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-fill"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="/logout">Keluar</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="main-content">


        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                toast: true,
                position: 'top-end'
            });
        @endif

        function confirmDelete(url, message) {
            Swal.fire({
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
                width: '320px',
                customClass: {
                    popup: 'rounded-4 shadow-sm',
                    confirmButton: 'btn btn-sm btn-danger px-4 rounded-pill',
                    cancelButton: 'btn btn-sm btn-light px-4 rounded-pill text-dark border'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }
    </script>
</body>
</html>
