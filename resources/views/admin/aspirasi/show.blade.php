@extends('layouts.dashboard')

@section('title', 'Detail Aspirasi')

@section('content')
    <div class="d-flex align-items-center mb-4">
        <a href="/admin/aspirasi" class="btn btn-white btn-sm shadow-sm border rounded-pill me-3 px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
        <div>
            <h3 class="fw-bold mb-0">Detail Aspirasi</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                        <div>
                            <span class="text-muted small">Siswa:</span>
                            <strong>{{ $aspirasi->nama }}</strong>
                        </div>
                        <div>
                            <span class="text-muted small">Kategori:</span>
                            <span class="badge bg-primary">{{ $aspirasi->nama_kategori }}</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
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
                        <div>
                            <span class="text-muted small">NISN:</span>
                            <span class="font-monospace">{{ $aspirasi->nisn }}</span>
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

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0 fw-bold">Tanggapan</h6>
                </div>
                <div class="card-body">
                    @if (count($umpan_balik) > 0)
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            @foreach ($umpan_balik as $u)
                                <div
                                    style="background: #f8f9fa; padding: 12px 16px; border-radius: 8px; border-left: 4px solid #0d6efd;">
                                    <div
                                        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                        <small class="fw-bold">{{ $u->nama_lengkap }}</small>
                                        <small
                                            class="text-muted">{{ date('d M Y, H:i', strtotime($u->tanggal_tanggapan)) }}</small>
                                    </div>
                                    <p class="mb-0">{{ $u->tanggapan }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">Belum ada tanggapan.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            @if ($aspirasi->status !== 'Selesai')
                <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-header bg-white border-0 py-3">
                        <h6 class="mb-0 fw-bold"><i class="bi bi-reply me-2"></i>Tanggapi Aspirasi</h6>
                    </div>
                    <div class="card-body">
                        <form action="/admin/aspirasi/{{ $aspirasi->id_aspirasi }}/tanggapi" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Tanggapan</label>
                                <textarea name="tanggapan" class="form-control" rows="5" placeholder="Tulis tanggapan Anda..." required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="Diproses">Diproses</option>
                                    <option value="Selesai">Selesai</option>
                                </select>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-send me-2"></i>Kirim Tanggapan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="alert alert-success border-0">
                    <i class="bi bi-check-circle me-2"></i>Aspirasi sudah ditanggapi
                </div>
            @endif
        </div>
    </div>
@endsection
