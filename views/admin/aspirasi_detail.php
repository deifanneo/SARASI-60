<?php
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php?page=login");
    exit;
}

$id = $_GET['id'];
$admin_id = $_SESSION['user_id'];

// Handle Post (Update Status / Feedbcak)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = $_POST['status'];
    $feedback = $_POST['feedback'];

    // Update Status
    $stmt = $conn->prepare("UPDATE aspirasi SET status = ? WHERE id_aspirasi = ?");
    $stmt->execute([$status, $id]);

    // Insert/Update Feedback
    // Check if feedback exists
    $check = $conn->prepare("SELECT id_umpan_balik FROM umpan_balik WHERE id_aspirasi = ?");
    $check->execute([$id]);
    
    if ($check->rowCount() > 0) {
        $up = $conn->prepare("UPDATE umpan_balik SET tanggapan = ?, id_admin = ?, tanggal_tanggapan = NOW() WHERE id_aspirasi = ?");
        $up->execute([$feedback, $admin_id, $id]);
    } else {
        $in = $conn->prepare("INSERT INTO umpan_balik (id_aspirasi, id_admin, tanggapan, tanggal_tanggapan) VALUES (?, ?, ?, NOW())");
        $in->execute([$id, $admin_id, $feedback]);
    }
    
    echo "<script>alert('Data berhasil diperbarui!'); window.location.href='index.php?page=aspirasi_detail&id=$id';</script>";
}

// Fetch Detail
$query = "
    SELECT a.*, s.nama as nama_siswa, s.kelas, k.nama_kategori 
    FROM aspirasi a
    JOIN siswa s ON a.nisn = s.nisn
    JOIN kategori k ON a.id_kategori = k.id_kategori
    WHERE a.id_aspirasi = ?
";
$stmt = $conn->prepare($query);
$stmt->execute([$id]);
$data = $stmt->fetch();

// Fetch Existing Feedback
$fb = $conn->prepare("SELECT * FROM umpan_balik WHERE id_aspirasi = ?");
$fb->execute([$id]);
$feedback_data = $fb->fetch();
$current_feedback = $feedback_data ? $feedback_data['tanggapan'] : '';
?>

<div class="container mt-4">
    <a href="index.php?page=dashboard_admin" class="btn btn-outline mb-4">&larr; Kembali</a>

    <div class="grid grid-cols-2">
        <!-- Detail Aspirasi -->
        <div class="card">
            <h3>Detail Aspirasi</h3>
            <div style="margin-top: 1rem;">
                <p><strong>Status:</strong> <span class="badge badge-<?= strtolower($data['status']) == 'diproses' ? 'diproses' : (strtolower($data['status']) == 'selesai' ? 'selesai' : 'diajukan') ?>"><?= $data['status'] ?></span></p>
                <p><strong>Kategori:</strong> <?= $data['nama_kategori'] ?></p>
                <p><strong>Lokasi:</strong> <?= $data['lokasi'] ?></p>
                <p><strong>Pelapor:</strong> <?= $data['nama_siswa'] ?> (<?= $data['kelas'] ?>)</p>
                <p><strong>Tanggal:</strong> <?= date('d M Y H:i', strtotime($data['tanggal_input'])) ?></p>
                
                <hr style="margin: 1rem 0; border: 0; border-top: 1px solid var(--border);">
                
                <h4><?= htmlspecialchars($data['judul']) ?></h4>
                <p class="mt-4" style="white-space: pre-wrap; color: var(--text-light);"><?= htmlspecialchars($data['isi']) ?></p>
            </div>
        </div>

        <!-- Action Form -->
        <div class="card">
            <h3>Tindak Lanjut</h3>
            <form method="POST" action="">
                <div class="form-group">
                    <label>Update Status</label>
                    <select name="status" class="form-control">
                        <option value="Diajukan" <?= $data['status']=='Diajukan'?'selected':'' ?>>Diajukan (Belum diproses)</option>
                        <option value="Diproses" <?= $data['status']=='Diproses'?'selected':'' ?>>Diproses (Sedang dikerjakan)</option>
                        <option value="Selesai" <?= $data['status']=='Selesai'?'selected':'' ?>>Selesai (Sudah beres)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Berikan Tanggapan / Umpan Balik</label>
                    <textarea name="feedback" rows="6" required placeholder="Tulis tanggapan untuk siswa..."><?= htmlspecialchars($current_feedback) ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>
