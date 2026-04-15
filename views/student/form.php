<?php
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'siswa') {
    header("Location: index.php?page=login");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nisn = $_SESSION['user_id'];
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $kategori = $_POST['kategori'];
    $lokasi = $_POST['lokasi'];

    // Handle Upload Foto (Optional as per basic requirement, but good to check)
    // Simplified for UKK speed: Just storing text inputs for now unless user asks.
    // The prompt says "Foto (optional)" in my plan, but database has it.
    // I won't complicated it with file upload for this turn unless critical.
    // Let's stick to text to be fast, or minimal file upload.
    // I'll skip file upload logic for speed unless prompt strictly required "Upload". Prompt just said "Input aspirasi".
    
    $stmt = $conn->prepare("INSERT INTO aspirasi (nisn, id_kategori, judul, isi, lokasi, user_id_created) VALUES (?, ?, ?, ?, ?, ?)"); 
    // Wait, my schema doesn't have create/update stamps that need logic, just timestamp default.
    // Re-checking schema: nisn, id_kategori, judul, isi, lokasi, tanggal_input, foto, status.
    
    $stmt = $conn->prepare("INSERT INTO aspirasi (nisn, id_kategori, judul, isi, lokasi) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$nisn, $kategori, $judul, $isi, $lokasi])) {
        echo "<script>alert('Aspirasi berhasil dikirim!'); window.location.href='index.php?page=dashboard_siswa';</script>";
    } else {
        echo "<script>alert('Gagal mengirim aspirasi.');</script>";
    }
}

// Fetch Kategori
$cats = $conn->query("SELECT * FROM kategori")->fetchAll();
?>

<div class="container mt-4" style="max-width: 800px;">
    <div class="card">
        <h2 class="mb-4">Tulis Aspirasi Baru</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label>Judul Laporan</label>
                <input type="text" name="judul" required placeholder="Contoh: Kursi Rusak di Kelas XII RPL 1">
            </div>

            <div class="grid grid-cols-2">
                <div class="form-group">
                    <label>Kategori</label>
                    <select name="kategori" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach($cats as $c): ?>
                            <option value="<?= $c['id_kategori'] ?>"><?= $c['nama_kategori'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Lokasi (Ruangan/Tempat)</label>
                    <input type="text" name="lokasi" required placeholder="Contoh: Lab Komputer 1">
                </div>
            </div>

            <div class="form-group">
                <label>Isi Keluhan / Saran</label>
                <textarea name="isi" rows="5" required placeholder="Jelaskan secara detail masalahnya..."></textarea>
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary">Kirim Aspirasi</button>
                <a href="index.php?page=dashboard_siswa" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
