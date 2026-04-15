<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SARASI | Sarana dan Aspirasi Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-blue: #1e3a5f;
            --dark-blue: #152a45;
            --light-blue: #f0f4f8;
            --accent-green: #4CAF50;
        }

        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            background-color: var(--light-blue);
        }

        .split-container {
            display: flex;
            height: 100vh;
        }

        /* Left Side: Branding - Simplified */
        .left-side {
            flex: 1;
            background: #1e3a5f;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            text-align: center;
        }

        .brand-logo {
            width: 120px;
            height: 120px;
            background: white;
            border-radius: 20px;
            padding: 15px;
            margin-bottom: 2rem;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .brand-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .brand-tagline {
            font-size: 1.1rem;
            opacity: 0.8;
            max-width: 400px;
            line-height: 1.5;
        }

        /* Right Side: Login Form - Simple */
        .right-side {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            background: white;
            padding: 2.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .nav-pills {
            margin-bottom: 2rem;
            background: #f1f5f9;
            padding: 5px;
            border-radius: 10px;
        }

        .nav-pills .nav-link {
            color: #64748b;
            border-radius: 8px;
            font-weight: 600;
            padding: 10px;
            transition: all 0.2s;
            cursor: pointer;
        }

        .nav-pills .nav-link.active {
            background-color: white;
            color: var(--primary-blue);
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: #475569;
        }

        .form-control {
            padding: 0.65rem 0.8rem;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(30, 58, 95, 0.1);
        }

        .btn-primary {
            background: var(--primary-blue);
            border: none;
            padding: 0.75rem;
            border-radius: 8px;
            font-weight: 600;
            width: 100%;
        }

        .btn-register-toggle {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
        }

        .hidden { display: none; }

        @media (max-width: 991.98px) {
            .split-container { flex-direction: column; height: auto; }
            .left-side, .right-side { padding: 3rem 1.5rem; }
            .brand-title { font-size: 2.2rem; }
        }
    </style>
</head>
<body>
    <div class="split-container">
        <!-- Brand Section -->
        <div class="left-side">
            <div class="brand-logo">
                <img src="{{ asset('logo-sarasi.png') }}" alt="SARASI Logo" style="width: 100%; height: 100%; object-fit: contain;">
            </div>
            <h1 class="brand-title">SARASI</h1>
            <p class="brand-tagline">
                Sarana dan Aspirasi Siswa. Sampaikan keluhan dan saran demi kenyamanan belajar di sekolah.
            </p>
        </div>

        <!-- Right Side -->
        <div class="right-side">
            <!-- Login Form Container -->
            <div id="loginSection" class="login-card">
                <h2 class="h4 mb-4 fw-bold text-center">Masuk ke Sistem</h2>
                
                <ul class="nav nav-pills nav-fill mb-4" id="roleTabs">
                    <li class="nav-item">
                        <a class="nav-link active" onclick="toggleRole('siswa', this)">Siswa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="toggleRole('admin', this)">Admin</a>
                    </li>
                </ul>

                <form action="/login" method="POST">
                    @csrf
                    <input type="hidden" name="role" id="roleInput" value="siswa">
                    
                    <div class="mb-3">
                        <label id="userLabel" class="form-label">NISN</label>
                        <input type="text" name="username" id="userInput" class="form-control" placeholder="Masukkan NISN" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kata Sandi</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan kata sandi" required>
                    </div>

                    <button type="submit" class="btn btn-primary mb-3">Masuk Sekarang</button>
                    
                </form>
            </div>

        </div>
    </div>

    @if(session('error'))
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050">
            <div class="alert alert-danger alert-dismissible fade show shadow" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if(session('success'))
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050">
            <div class="alert alert-success alert-dismissible fade show shadow" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleRole(role, element) {
            const tabs = document.querySelectorAll('#roleTabs .nav-link');
            tabs.forEach(tab => tab.classList.remove('active'));
            
            element.classList.add('active');
            
            document.getElementById('roleInput').value = role;
            document.getElementById('userLabel').innerText = role === 'siswa' ? 'NISN' : 'Email';
            document.getElementById('userInput').placeholder = role === 'siswa' ? 'Masukkan NISN' : 'admin@example.com';
            document.getElementById('userInput').type = role === 'siswa' ? 'text' : 'email';
        }

    </script>
</body>
</html>
