@extends('layouts.dashboard')

@section('title', 'Daftar Aspirasi')

@section('content')
    <div class="mb-4">
        <h3 class="fw-bold mb-0">Daftar Semua Aspirasi</h3>
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Cari nama:</label>
                    <input type="text" id="search" name="search" class="form-control form-control-sm"
                        value="{{ request('search') }}" placeholder="Masukkan nama siswa">
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Filter status:</label>
                    <select id="status" name="status" class="form-select form-select-sm">
                        <option value=""
                            {{ request('status') === null || request('status') === '' ? 'selected' : '' }}>
                            Semua Status</option>
                        <option value="Diajukan" {{ request('status') === 'Diajukan' ? 'selected' : '' }}>Diajukan</option>
                        <option value="Diproses" {{ request('status') === 'Diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="Selesai" {{ request('status') === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="tanggal" class="form-label">Filter tanggal:</label>
                    <input type="date" id="tanggal" name="tanggal" class="form-control form-control-sm"
                        value="{{ request('tanggal') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary btn-sm w-100">Terapkan</button>
                </div>
            </form>
        </div>
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
