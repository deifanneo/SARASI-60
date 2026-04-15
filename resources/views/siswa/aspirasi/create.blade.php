@extends('layouts.dashboard')

@section('title', 'Buat Aspirasi')

@section('content')
<div class="d-flex align-items-center mb-4">
    <a href="/dashboard-siswa" class="btn btn-white btn-sm shadow-sm border rounded-pill me-3 px-3">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
    <div>
        <h3 class="fw-bold mb-0">Buat Aspirasi Baru</h3>
        <p class="text-muted mb-0">Sampaikan aspirasi, keluhan, atau saran kamu secara sopan.</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="/siswa/aspirasi" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Kategori</label>
                            <select name="id_kategori" class="form-select" required>
                                <option value="" selected disabled>Pilih Kategori</option>
                                @foreach($kategori as $k)
                                <option value="{{ $k->id_kategori }}">{{ $k->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Lokasi (Opsional)</label>
                            <input type="text" name="lokasi" class="form-control" placeholder="Contoh: Lab Komputer, Kantin">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small">Judul Aspirasi</label>
                        <input type="text" name="judul" class="form-control" placeholder="Singkat dan jelas" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small">Isi Aspirasi</label>
                        <textarea name="isi" class="form-control" rows="8" placeholder="Ceritakan detail aspirasi kamu di sini..." required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small">Lampiran Foto (Opsional)</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                        <small class="text-muted">Format: JPG, PNG, JPEG. Max: 2MB</small>
                    </div>

                    <hr class="mb-4">
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Kirim Aspirasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card bg-light border-0">
            <div class="card-body">
                <h6 class="fw-bold"><i class="bi bi-info-circle me-1"></i> Panduan Pengisian</h6>
                <ul class="small mt-3 ps-3">
                    <li class="mb-2">Gunakan bahasa yang baik dan benar.</li>
                    <li class="mb-2">Pilih kategori yang sesuai dengan permasalahan.</li>
                    <li class="mb-2">Berikan lokasi yang spesifik jika aspirasi terkait fasilitas fisik.</li>
                    <li class="mb-2">Lampirkan foto jika diperlukan untuk memperjelas laporan.</li>
                    <li>Siswa bertanggung jawab atas kebenaran laporan yang dikirimkan.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
