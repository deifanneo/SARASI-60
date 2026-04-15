<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SARASI | Sarana dan Aspirasi Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-blue: #1e3a5f;
            --dark-blue: #152a45;
            --light-blue: #e8eef5;
            --accent-green: #4CAF50;
            --bg-gradient: linear-gradient(135deg, #1e3a5f 0%, #152a45 100%);
        }

        body {
            background: linear-gradient(135deg, #1e3a5f 0%, #2d4a6f 50%, #152a45 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            max-width: 450px;
            margin: 0 auto;
        }

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, #1e3a5f 0%, #152a45 100%);
            color: white;
            padding: 2rem;
            text-align: center;
            border: none;
        }

        .card-header h3 {
            margin: 0;
            font-weight: 600;
        }

        .card-header p {
            margin: 0.5rem 0 0 0;
            opacity: 0.9;
            font-size: 0.9rem;
        }

        .card-body {
            padding: 2.5rem;
        }

        .form-label {
            font-weight: 500;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.15);
        }

        .input-group-text {
            background-color: white;
            border: 2px solid #e0e0e0;
            border-right: none;
            border-radius: 10px 0 0 10px;
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }

        .input-group:focus-within .input-group-text {
            border-color: #4CAF50;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            border: none;
            border-radius: 10px;
            padding: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(76, 175, 80, 0.4);
            background: linear-gradient(135deg, #45a049 0%, #3d8b40 100%);
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.5rem 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #ddd;
        }

        .divider span {
            padding: 0 1rem;
            color: #666;
            font-size: 0.9rem;
        }

        .school-logo {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .alert {
            border-radius: 10px;
            border: none;
        }

        .link-primary {
            color: #4CAF50;
            text-decoration: none;
            font-weight: 500;
        }

        .link-primary:hover {
            text-decoration: underline;
            color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="card">
                <div class="card-header">
                    <div class="school-logo">
                        <img src="logo-sarasi.png" alt="Logo SARASI" style="width: 100%; height: 100%; object-fit: contain; padding: 10px;">
                    </div>
                    <h3>Selamat Datang di SARASI</h3>
                    <p>Sarana dan Aspirasi Siswa</p>
                </div>
                <div class="card-body">
                    <!-- Alert contoh (hide by default) -->
                    <div class="alert alert-danger d-none" id="errorAlert">
                        <i class="bi bi-exclamation-circle"></i> Email atau password salah!
                    </div>

                    <form id="loginForm">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email" class="form-control" id="email" placeholder="nama@sekolah.com" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password" class="form-control" id="password" placeholder="Masukkan password" required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember">
                            <label class="form-check-label" for="remember">
                                Ingat saya
                            </label>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-box-arrow-in-right"></i> Masuk
                            </button>
                        </div>

                        <div class="text-center">
                            <a href="#" class="link-primary">Lupa Password?</a>
                        </div>

                        <div class="divider">
                            <span>atau</span>
                        </div>

                        <div class="text-center">
                            <p class="mb-0">Belum punya akun? <a href="register.html" class="link-primary">Daftar Sekarang</a></p>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-center mt-3 text-white">
                <small>&copy; 2025 SARASI - Sarana dan Aspirasi Siswa</small>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const password = document.getElementById('password');
            const icon = this.querySelector('i');

            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });

        // Form submission (untuk demo)
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            // Simulasi login (ganti dengan AJAX ke Laravel backend)
            console.log('Login attempt:', { email, password });

            // Contoh redirect ke dashboard
            // window.location.href = 'dashboard.html';

            alert('Form login berhasil! Di Laravel, ini akan mengirim ke route login.');
        });
    </script>
</body>
</html>
