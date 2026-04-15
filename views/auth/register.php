<?php
$msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nisn = $_POST['nisn'];
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    try {
        $stmt = $conn->prepare("INSERT INTO siswa (nisn, nama, kelas, password) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nisn, $nama, $kelas, $password]);
        
        // Auto login or redirect
        echo "<script>alert('Pendaftaran Berhasil! Silahkan Login.'); window.location.href='index.php?page=login';</script>";
        exit;
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $msg = "NISN sudah terdaftar!";
        } else {
            $msg = "Gagal mendaftar: " . $e->getMessage();
        }
    }
}
?>

<div class="login-container">
    <div class="card">
        <h2 class="text-center mb-4">Daftar Siswa</h2>
        
        <?php if ($msg): ?>
            <div style="background: #fee2e2; color: #991b1b; padding: 0.75rem; border-radius: 0.375rem; margin-bottom: 1rem; text-align: center;">
                <?= $msg ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label>NISN</label>
                <input type="text" name="nisn" required maxlength="10" placeholder="Nomor Induk Siswa Nasional">
            </div>

            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" required placeholder="Nama Lengkap">
            </div>

            <div class="form-group">
                <label>Kelas</label>
                <input type="text" name="kelas" required placeholder="Contoh: XII RPL 1">
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required placeholder="Buat Password">
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%;">Daftar</button>
        </form>
        
        <p class="text-center mt-4" style="font-size: 0.9rem;">
            Sudah punya akun? <a href="index.php?page=login" style="color: var(--primary);">Login disini</a>
        </p>
    </div>
</div>
