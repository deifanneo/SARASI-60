@extends('layouts.dashboard')

@section('title', 'Edit Aspirasi')

@section('content')
<div class="d-flex align-items-center mb-4">
    <a href="/dashboard-siswa" class="btn btn-white btn-sm shadow-sm border rounded-pill me-3 px-3">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
    <div>
        <h3 class="fw-bold mb-0">Edit Aspirasi</h3>
        <p class="text-muted mb-0">Kamu masih bisa mengubah aspirasi karena statusnya masih "Diajukan".</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="/siswa/aspirasi/{{ $aspirasi->id_aspirasi }}/update" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Kategori</label>
                            <select name="id_kategori" class="form-select" required>
                                <option value="" disabled>Pilih Kategori</option>
                                @foreach($kategori as $k)
                                <option value="{{ $k->id_kategori }}" {{ $aspirasi->id_kategori == $k->id_kategori ? 'selected' : '' }}>
                                    {{ $k->nama_kategori }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Lokasi (Opsional)</label>
                            <input type="text" name="lokasi" value="{{ $aspirasi->lokasi }}" class="form-control" placeholder="Contoh: Lab Komputer, Kantin">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small">Judul Aspirasi</label>
                        <input type="text" name="judul" value="{{ $aspirasi->judul }}" class="form-control" placeholder="Singkat dan jelas" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small">Isi Aspirasi</label>
                        <textarea name="isi" class="form-control" rows="8" placeholder="Ceritakan detail aspirasi kamu di sini..." required>{{ $aspirasi->isi }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small">Lampiran Foto (Opsional)</label>
                        @if($aspirasi->foto)
                            <div class="mb-2">
                                <small class="text-muted d-block mb-1">Foto saat ini:</small>
                                <img src="{{ asset('storage/' . $aspirasi->foto) }}" class="img-thumbnail" style="max-height: 150px;" alt="Aspirasi Image">
                            </div>
                            <small class="text-muted d-block mb-2">Unggah foto baru untuk mengganti yang lama, atau biarkan kosong jika tidak ingin mengubah.</small>
                        @endif
                        <input type="file" name="foto" class="form-control" accept="image/*">
                        <small class="text-muted mt-1 d-block">Format: JPG, PNG, JPEG. Max: 2MB</small>
                    </div>

                    <hr class="mb-4">
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card bg-light border-0">
            <div class="card-body">
                <h6 class="fw-bold"><i class="bi bi-info-circle me-1"></i> Informasi</h6>
                <p class="small text-muted mt-2">
                    Aspirasi hanya bisa diedit ketika statusnya masih <strong>Diajukan</strong>. 
                    Jika admin sudah mulai memproses (status berubah menjadi <strong>Diproses</strong> atau <strong>Selesai</strong>), kamu tidak bisa lagi mengubah aspirasi ini.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
