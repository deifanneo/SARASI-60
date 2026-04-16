@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="row g-4 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm p-3 text-center">
                <div class="display-6 fw-bold text-primary">{{ $stats['total'] }}</div>
                <div class="text-muted small uppercase fw-bold">Total Aspirasi</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm p-3 text-center">
                <div class="display-6 fw-bold text-warning">{{ $stats['diajukan'] }}</div>
                <div class="text-muted small uppercase fw-bold">Diajukan</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm p-3 text-center">
                <div class="display-6 fw-bold text-info">{{ $stats['diproses'] }}</div>
                <div class="text-muted small uppercase fw-bold">Diproses</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm p-3 text-center">
                <div class="display-6 fw-bold text-success">{{ $stats['selesai'] }}</div>
                <div class="text-muted small uppercase fw-bold">Selesai</div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Aspirasi Terbaru</h5>
            <a href="/admin/aspirasi" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Tgl Input</th>
                            <th>Siswa</th>
                            <th>Kategori</th>
                            <th>Judul</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latest_aspirasi as $a)
                            <tr>
                                <td class="ps-4">{{ date('d M Y', strtotime($a->tanggal_input)) }}</td>
                                <td>{{ $a->nama }}</td>
                                <td><span class="badge bg-secondary">{{ $a->nama_kategori }}</span></td>
                                <td>{{ $a->judul }}</td>
                                <td>
                                    @php
                                        $badge = 'bg-warning';
                                        if ($a->status == 'Diproses') {
                                            $badge = 'bg-info';
                                        }
                                        if ($a->status == 'Selesai') {
                                            $badge = 'bg-success';
                                        }
                                    @endphp
                                    <span class="badge {{ $badge }}">{{ $a->status }}</span>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="/admin/aspirasi/{{ $a->id_aspirasi }}"
                                        class="btn btn-sm btn-outline-info shadow-sm px-3" title="Detail"><i
                                            class="bi bi-eye"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Belum ada aspirasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
