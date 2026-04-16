@extends('layouts.dashboard')

@section('title', 'Detail Aspirasi')

@section('content')
    <div class="d-flex align-items-center mb-4">
        <a href="/admin/aspirasi" class="btn btn-white btn-sm shadow-sm border rounded-pill me-3 px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
        <div>
            <h3 class="fw-bold mb-0">Detail Aspirasi #{{ $aspirasi->id_aspirasi }}</h3>
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
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold">Tanggapan</h6>
                    @if ($aspirasi->status !== 'Selesai')
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#tanggapiModal">
                            <i class="bi bi-reply me-1"></i> Tanggapi
                        </button>
                    @endif
                </div>
                <div class="card-body">
                    @if (count($umpan_balik) > 0)
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
                    @else
                        <p class="text-muted mb-0">Belum ada tanggapan.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tanggapi -->
    <div class="modal fade" id="tanggapiModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tanggapi Aspirasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="/admin/aspirasi/{{ $aspirasi->id_aspirasi }}/tanggapi" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Tanggapan</label>
                            <textarea name="tanggapan" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="Diproses">Diproses</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Kirim Tanggapan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
