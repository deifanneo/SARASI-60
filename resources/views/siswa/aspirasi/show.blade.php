@extends('layouts.dashboard')

@section('title', 'Detail Aspirasi')

@section('content')
<div class="d-flex align-items-center mb-4">
    <a href="/dashboard-siswa" class="btn btn-white btn-sm shadow-sm border rounded-pill me-3 px-3">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
    <div>
        <h3 class="fw-bold mb-0">Aspirasi Saya #{{ $aspirasi->id_aspirasi }}</h3>
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
                        @php
                            $badge = 'bg-warning';
                            if($aspirasi->status == 'Diproses') $badge = 'bg-info';
                            if($aspirasi->status == 'Selesai') $badge = 'bg-success';
                        @endphp
                        <span class="badge {{ $badge }}">{{ $aspirasi->status }}</span>
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
                
                <div class="p-3 bg-light rounded d-flex justify-content-between mt-4">
                    <div>
                        <small class="text-muted d-block">Waktu Input</small>
                        <strong>{{ date('d M Y, H:i', strtotime($aspirasi->tanggal_input)) }}</strong>
                    </div>
                    @if($aspirasi->lokasi)
                    <div class="text-end">
                        <small class="text-muted d-block">Lokasi</small>
                        <strong>{{ $aspirasi->lokasi }}</strong>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <h5 class="fw-bold mb-3">Tanggapan Admin</h5>
        @forelse($umpan_balik as $ub)
        <div class="card mb-3 border-0 shadow-sm border-start border-primary border-4">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between mb-2">
                    <strong class="text-primary">{{ $ub->nama_lengkap }}</strong>
                    <small class="text-muted">{{ date('d M Y', strtotime($ub->tanggal_tanggapan)) }}</small>
                </div>
                <p class="mb-0 small">{{ $ub->tanggapan }}</p>
            </div>
        </div>
        @empty
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 text-center text-muted">
                <i class="bi bi-clock-history display-6 d-block mb-2 opacity-25"></i>
                <p class="mb-0">Belum ada tanggapan dari admin.</p>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
