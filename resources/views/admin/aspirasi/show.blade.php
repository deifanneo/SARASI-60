@extends('layouts.dashboard')

@section('title', 'Detail Aspirasi')

@section('content')
<div class="d-flex align-items-center mb-4">
    <a href="/admin/aspirasi" class="btn btn-white btn-sm shadow-sm border rounded-pill me-3 px-3">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
    <div>
        <h3 class="fw-bold mb-0">Aspirasi #{{ $aspirasi->id_aspirasi }}</h3>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                    <div>
                        <span class="text-muted small">Kategori:</span>
                        <span class="badge bg-primary">{{ $aspirasi->nama_kategori }}</span>
                    </div>
                    <div>
                        <span class="text-muted small">Status:</span>
                        <span class="badge bg-info">{{ $aspirasi->status }}</span>
                    </div>
                </div>

                <h4 class="fw-bold mb-3">{{ $aspirasi->judul }}</h4>
                <p class="mb-4" style="white-space: pre-wrap; line-height: 1.6;">{{ $aspirasi->isi }}</p>

                @if($aspirasi->foto)
                <div class="mb-4">
                    <p class="text-muted small mb-1">Lampiran Foto:</p>
                    <img src="{{ asset('storage/' . $aspirasi->foto) }}" class="img-fluid rounded border" style="max-height: 400px;" alt="Aspirasi Image">
                </div>
                @endif

                <div class="p-3 bg-light rounded d-flex justify-content-between">
                    <div>
                        <small class="text-muted d-block">Nama Siswa</small>
                        <strong>{{ $aspirasi->nama }} ({{ $aspirasi->nisn }})</strong>
                    </div>
                    <div class="text-end">
                        <small class="text-muted d-block">Waktu Input</small>
                        <strong>{{ date('d M Y, H:i', strtotime($aspirasi->tanggal_input)) }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <h5 class="fw-bold mb-3">Tanggapan & Riwayat</h5>
        @forelse($umpan_balik as $ub)
        <div class="card mb-3 border-start border-primary border-4">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between mb-2">
                    <strong class="text-primary">{{ $ub->nama_lengkap }} (Admin)</strong>
                    <small class="text-muted">{{ date('d M Y, H:i', strtotime($ub->tanggal_tanggapan)) }}</small>
                </div>
                <p class="mb-0">{{ $ub->tanggapan }}</p>
            </div>
        </div>
        @empty
        <div class="alert alert-light border text-center text-muted py-4 mb-4">
            Belum ada tanggapan untuk aspirasi ini.
        </div>
        @endforelse
    </div>

    <div class="col-lg-4">
        <div class="card sticky-top" style="top: 100px;">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">Berikan Tanggapan</h6>
            </div>
            <div class="card-body">
                <form action="/admin/aspirasi/{{ $aspirasi->id_aspirasi }}/tanggapi" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Isi Tanggapan</label>
                        <textarea name="tanggapan" class="form-control" rows="5" placeholder="Tulis tanggapan atau solusi..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Ubah Status</label>
                        <select name="status" class="form-select" required>
                            <option value="Diproses" {{ $aspirasi->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="Selesai" {{ $aspirasi->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Kirim Tanggapan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
