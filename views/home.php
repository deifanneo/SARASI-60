<div class="card text-center" style="padding: 4rem 2rem; border: none; background: linear-gradient(to bottom right, #eff6ff, #fff);">
    <h1 style="font-size: 2.5rem; color: var(--primary-dark); margin-bottom: 1rem;">Suarakan Aspirasimu!</h1>
    <p style="font-size: 1.25rem; color: var(--secondary); margin-bottom: 2rem; max-width: 600px; margin-left: auto; margin-right: auto;">
        SARASI adalah wadah bagi siswa untuk menyampaikan pengaduan dan saran terkait sarana dan prasarana sekolah agar kegiatan belajar mengajar lebih nyaman.
    </p>
    
    <div style="display: flex; gap: 1rem; justify-content: center;">
        <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="index.php?page=register" class="btn btn-primary" style="padding: 0.75rem 1.5rem; font-size: 1.1rem;">Daftar Sekarang</a>
            <a href="index.php?page=login" class="btn btn-outline" style="padding: 0.75rem 1.5rem; font-size: 1.1rem;">Masuk</a>
        <?php else: ?>
            <a href="index.php?page=tulis_aspirasi" class="btn btn-primary" style="padding: 0.75rem 1.5rem; font-size: 1.1rem;">Tulis Aspirasi</a>
        <?php endif; ?>
    </div>
</div>

<div class="grid grid-cols-2 mt-4">
    <div class="card">
        <h3>Transparan & Terbuka</h3>
        <p class="mt-4" style="color: var(--text-light);">
            Pantau status pengaduanmu secara real-time. Mulai dari diajukan, diproses, hingga selesai diperbaiki.
        </p>
    </div>
    <div class="card">
        <h3>Respon Cepat</h3>
        <p class="mt-4" style="color: var(--text-light);">
            Admin dan petugas sekolah siap menindaklanjuti setiap laporan yang masuk demi kenyamanan bersama.
        </p>
    </div>
</div>
