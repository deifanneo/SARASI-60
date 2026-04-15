<?php
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php?page=login");
    exit;
}

// Stats
$total = $conn->query("SELECT COUNT(*) FROM aspirasi")->fetchColumn();
$diajukan = $conn->query("SELECT COUNT(*) FROM aspirasi WHERE status='Diajukan'")->fetchColumn();
$diproses = $conn->query("SELECT COUNT(*) FROM aspirasi WHERE status='Diproses'")->fetchColumn();
$selesai = $conn->query("SELECT COUNT(*) FROM aspirasi WHERE status='Selesai'")->fetchColumn();

// Filtering
$where = "1";
$params = [];

if (isset($_GET['status']) && $_GET['status'] != '') {
    $where .= " AND a.status = ?";
    $params[] = $_GET['status'];
}

// Fetch Logic
$query = "
    SELECT a.*, s.nama as nama_siswa, k.nama_kategori 
    FROM aspirasi a
    JOIN siswa s ON a.nisn = s.nisn
    JOIN kategori k ON a.id_kategori = k.id_kategori
    WHERE $where
    ORDER BY a.tanggal_input DESC
";
$stmt = $conn->prepare($query);
$stmt->execute($params);
$aspirasis = $stmt->fetchAll();
?>

<div class="container mt-4">
    <h2>Dashboard Admin</h2>
    <div class="grid grid-cols-2 mb-4" style="grid-template-columns: repeat(4, 1fr);">
        <div class="card text-center" style="padding: 1rem;">
            <h3><?= $total ?></h3>
            <p style="color: var(--text-light); font-size: 0.8rem;">Total Aspirasi</p>
        </div>
        <div class="card text-center" style="padding: 1rem; border-top: 3px solid #0ea5e9;">
            <h3><?= $diajukan ?></h3>
            <p style="color: var(--text-light); font-size: 0.8rem;">Diajukan</p>
        </div>
        <div class="card text-center" style="padding: 1rem; border-top: 3px solid #f59e0b;">
            <h3><?= $diproses ?></h3>
            <p style="color: var(--text-light); font-size: 0.8rem;">Diproses</p>
        </div>
        <div class="card text-center" style="padding: 1rem; border-top: 3px solid #22c55e;">
            <h3><?= $selesai ?></h3>
            <p style="color: var(--text-light); font-size: 0.8rem;">Selesai</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h3>Daftar Masuk</h3>
            <form method="GET" style="display: flex; gap: 0.5rem;">
                <input type="hidden" name="page" value="dashboard_admin">
                <select name="status" style="padding: 0.25rem;">
                    <option value="">Semua Status</option>
                    <option value="Diajukan" <?= (isset($_GET['status']) && $_GET['status']=='Diajukan')?'selected':'' ?>>Diajukan</option>
                    <option value="Diproses" <?= (isset($_GET['status']) && $_GET['status']=='Diproses')?'selected':'' ?>>Diproses</option>
                    <option value="Selesai" <?= (isset($_GET['status']) && $_GET['status']=='Selesai')?'selected':'' ?>>Selesai</option>
                </select>
                <button type="submit" class="btn btn-outline" style="padding: 0.25rem 0.5rem;">Filter</button>
            </form>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Tgl</th>
                    <th>Siswa</th>
                    <th>Kategori</th>
                    <th>Keluhan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($aspirasis as $row): ?>
                <tr>
                    <td><?= date('d/m/y', strtotime($row['tanggal_input'])) ?></td>
                    <td><?= htmlspecialchars($row['nama_siswa']) ?></td>
                    <td><?= htmlspecialchars($row['nama_kategori']) ?></td>
                    <td><?= htmlspecialchars(substr($row['judul'], 0, 30)) ?>...</td>
                    <td>
                        <?php
                        $badgeClass = 'badge-diajukan';
                        if($row['status'] == 'Diproses') $badgeClass = 'badge-diproses';
                        if($row['status'] == 'Selesai') $badgeClass = 'badge-selesai';
                        ?>
                        <span class="badge <?= $badgeClass ?>"><?= $row['status'] ?></span>
                    </td>
                    <td>
                        <a href="index.php?page=aspirasi_detail&id=<?= $row['id_aspirasi'] ?>" class="btn btn-primary" style="padding: 0.25rem 0.75rem; font-size: 0.8rem;">Detail</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
