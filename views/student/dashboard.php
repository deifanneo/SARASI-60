<?php
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'siswa') {
    header("Location: index.php?page=login");
    exit;
}

$nisn = $_SESSION['user_id'];

// Fetch Aspirations for this student
$query = "
    SELECT a.*, k.nama_kategori, u.tanggapan, u.tanggal_tanggapan, adm.nama_lengkap as nama_admin 
    FROM aspirasi a
    JOIN kategori k ON a.id_kategori = k.id_kategori
    LEFT JOIN umpan_balik u ON a.id_aspirasi = u.id_aspirasi
    LEFT JOIN admin adm ON u.id_admin = adm.id_admin
    WHERE a.nisn = ?
    ORDER BY a.tanggal_input DESC
";
$stmt = $conn->prepare($query);
$stmt->execute([$nisn]);
$aspirasis = $stmt->fetchAll();
?>

<div class="container mt-4">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h2>Halo, <?= htmlspecialchars($_SESSION['nama']) ?>!</h2>
            <p style="color: var(--text-light);">Selamat datang di Dashboard Siswa.</p>
        </div>
        <a href="index.php?page=tulis_aspirasi" class="btn btn-primary">+ Tulis Aspirasi Baru</a>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Riwayat Aspirasi Kamu</h3>
        </div>
        
        <?php if (count($aspirasis) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Kategori</th>
                        <th width="20%">Judul & Isi</th>
                        <th width="15%">Tanggal</th>
                        <th width="10%">Status</th>
                        <th width="35%">Umpan Balik</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($aspirasis as $row): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['nama_kategori']) ?></td>
                            <td>
                                <strong><?= htmlspecialchars($row['judul']) ?></strong><br>
                                <span style="font-size: 0.9rem; color: var(--text-light);">
                                    <?= htmlspecialchars(substr($row['isi'], 0, 50)) ?><?= strlen($row['isi']) > 50 ? '...' : '' ?>
                                </span>
                            </td>
                            <td><?= date('d M Y H:i', strtotime($row['tanggal_input'])) ?></td>
                            <td>
                                <?php
                                $badgeClass = 'badge-diajukan';
                                if($row['status'] == 'Diproses') $badgeClass = 'badge-diproses';
                                if($row['status'] == 'Selesai') $badgeClass = 'badge-selesai';
                                ?>
                                <span class="badge <?= $badgeClass ?>"><?= $row['status'] ?></span>
                            </td>
                            <td style="background-color: #f9fafb;">
                                <?php if ($row['tanggapan']): ?>
                                    <div style="font-size: 0.9rem;">
                                        <strong><?= htmlspecialchars($row['nama_admin']) ?>:</strong><br>
                                        <?= htmlspecialchars($row['tanggapan']) ?>
                                        <div style="font-size: 0.8rem; color: #9ca3af; margin-top: 4px;">
                                            <?= date('d M Y', strtotime($row['tanggal_tanggapan'])) ?>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <span style="color: #9ca3af; font-style: italic;">Belum ada tanggapan</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div style="text-align: center; padding: 2rem; color: var(--text-light);">
                <p>Belum ada aspirasi yang kamu kirim.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
