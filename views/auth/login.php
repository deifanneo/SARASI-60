<?php
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username']; // Can be NISN or Username
    $password = $_POST['password'];
    $role = $_POST['role']; // 'siswa' or 'admin'

    if ($role == 'siswa') {
        $stmt = $conn->prepare("SELECT * FROM siswa WHERE nisn = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['nisn'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['role'] = 'siswa';
            header("Location: index.php?page=dashboard_siswa");
            exit;
        } else {
            $error = "NISN atau Password salah!";
        }
    } else {
        $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id_admin'];
            $_SESSION['nama'] = $user['nama_lengkap'];
            $_SESSION['level'] = $user['level'];
            $_SESSION['role'] = 'admin';
            header("Location: index.php?page=dashboard_admin");
            exit;
        } else {
            $error = "Username atau Password salah!";
        }
    }
}
?>

<div class="login-container">
    <div class="card">
        <h2 class="text-center mb-4">Masuk ke SARASI</h2>
        
        <?php if ($error): ?>
            <div style="background: #fee2e2; color: #991b1b; padding: 0.75rem; border-radius: 0.375rem; margin-bottom: 1rem; text-align: center;">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label>Login Sebagai</label>
                <select name="role" id="role" onchange="updateLabel()" required>
                    <option value="siswa">Siswa</option>
                    <option value="admin">Admin / Petugas</option>
                </select>
            </div>

            <div class="form-group">
                <label id="userLabel">NISN</label>
                <input type="text" name="username" required placeholder="Masukkan NISN / Username">
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required placeholder="Masukkan Password">
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%;">Masuk</button>
        </form>
        
        <p class="text-center mt-4" style="font-size: 0.9rem;">
            Belum punya akun? <a href="index.php?page=register" style="color: var(--primary);">Daftar disini (Siswa)</a>
        </p>
    </div>
</div>

<script>
function updateLabel() {
    const role = document.getElementById('role').value;
    const label = document.getElementById('userLabel');
    if (role === 'siswa') {
        label.innerText = 'NISN';
    } else {
        label.innerText = 'Username';
    }
}
</script>
