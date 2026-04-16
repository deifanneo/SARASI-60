@extends('layouts.dashboard')

@section('title', 'Daftar Aspirasi')

@section('content')
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h3 class="fw-bold mb-0">Daftar Semua Aspirasi</h3>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Tgl Input</th>
                            <th>NISN</th>
                            <th>Nama Siswa</th>
                            <th>Kategori</th>
                            <th>Judul</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($aspirasi as $a)
                            <tr>
                                <td class="ps-4 font-monospace small">{{ date('d/m/Y H:i', strtotime($a->tanggal_input)) }}
                                </td>
                                <td>{{ $a->nisn }}</td>
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
                                        class="btn btn-sm btn-outline-primary shadow-sm px-3 me-1" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger shadow-sm px-3"
                                        @if ($a->status !== 'Selesai') disabled title="Hapus aspirasi hanya bisa dilakukan jika status sudah Selesai" @endif
                                        onclick="confirmDelete('/admin/aspirasi/{{ $a->id_aspirasi }}/delete', 'Hapus aspirasi ini?')"
                                        title="Hapus">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">Tidak ada data aspirasi ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
