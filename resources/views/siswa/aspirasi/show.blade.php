@extends('layouts.dashboard')

@section('title', 'Detail Aspirasi')

@section('content')
    <div class="d-flex align-items-center mb-4">
        <a href="/dashboard-siswa" class="btn btn-white btn-sm shadow-sm border rounded-pill me-3 px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
        <div>
            <h3 class="fw-bold mb-0">Aspirasi Saya</h3>
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
                                if ($aspirasi->status == 'Diproses') {
                                    $badge = 'bg-info';
                                }
                                if ($aspirasi->status == 'Selesai') {
                                    $badge = 'bg-success';
                                }
                            @endphp
                            <span class="badge {{ $badge }}">{{ $aspirasi->status }}</span>
                        </div>
                    </div>

                    <h4 class="fw-bold mb-3">{{ $aspirasi->judul }}</h4>
                    <p class="mb-4" style="white-space: pre-wrap; line-height: 1.6;">{{ $aspirasi->isi }}</p>

                    @if ($aspirasi->foto)
                        <div class="mb-4">
                            <p class="text-muted small mb-1">Lampiran Foto:</p>
                            <img src="{{ asset('storage/' . $aspirasi->foto) }}" class="img-fluid rounded border"
                                style="max-height: 400px;" alt="Aspirasi Image">
                        </div>
                    @endif

                    <div class="p-3 bg-light rounded d-flex justify-content-between mt-4">
                        <div>
                            <small class="text-muted d-block">Waktu Input</small>
                            <strong>{{ date('d M Y, H:i', strtotime($aspirasi->tanggal_input)) }}</strong>
                        </div>
                        @if ($aspirasi->lokasi)
                            <div>
                                <small class="text-muted d-block">Lokasi</small>
                                <strong>{{ $aspirasi->lokasi }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @if (count($umpan_balik) > 0)
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h6 class="mb-0 fw-bold">Tanggapan Admin</h6>
                    </div>
                    <div class="card-body">
                        @foreach ($umpan_balik as $u)
                            <div class="border-start border-primary border-4 ps-3 mb-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <small class="text-muted">{{ $u->nama_lengkap }}</small>
                                    <small
                                        class="text-muted">{{ date('d M Y, H:i', strtotime($u->tanggal_tanggapan)) }}</small>
                                </div>
                                <p class="mb-0">{{ $u->tanggapan }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
