@extends('layouts.dashboard')

@section('title', 'Manajemen Siswa')

@section('content')
    <div class="mb-4">
        <h3 class="fw-bold">Manajemen Data Siswa</h3>
        <p class="text-muted">Tambah dan kelola data siswa yang terdaftar di sistem.</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-4">
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="mb-0 fw-bold">Tambah Siswa Baru</h6>
                </div>
                <div class="card-body">
                    <form action="/admin/siswa" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">NISN (10 Digit)</label>
                            <input type="text" name="nisn" class="form-control bg-light border-0"
                                value="{{ old('nisn') }}" placeholder="Contoh: 0012345678" maxlength="10" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control bg-light border-0"
                                value="{{ old('nama') }}" placeholder="Nama lengkap siswa" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Kelas</label>
                            <input type="text" name="kelas" class="form-control bg-light border-0"
                                value="{{ old('kelas') }}" placeholder="Contoh: XII RPL 1" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Kata Sandi</label>
                            <input type="password" name="password" class="form-control bg-light border-0"
                                placeholder="Min. 6 karakter" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 fw-bold py-2 mt-2">Daftarkan Siswa</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 border-0">Nama Siswa</th>
                                    <th class="py-3 border-0">NISN</th>
                                    <th class="py-3 border-0">Kelas</th>
                                    <th class="text-end pe-4 py-3 border-0">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($siswa as $s)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-success bg-opacity-10 p-2 me-3 text-success">
                                                    <i class="bi bi-person-badge-fill"></i>
                                                </div>
                                                <strong>{{ $s->nama }}</strong>
                                            </div>
                                        </td>
                                        <td class="font-monospace small text-muted">{{ $s->nisn }}</td>
                                        <td>{{ $s->kelas }}</td>
                                        <td class="text-end pe-4">
                                            <button class="btn btn-sm btn-outline-primary shadow-sm px-3 me-1"
                                                data-bs-toggle="modal" data-bs-target="#editSiswa{{ $s->nisn }}"
                                                title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger shadow-sm px-3"
                                                onclick="confirmDelete('/admin/siswa/{{ $s->nisn }}/delete', 'Hapus data siswa {{ addslashes($s->nama) }}?')"
                                                title="Hapus">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <i class="bi bi-people display-4 d-block mb-3 opacity-25"></i>
                                            Belum ada siswa terdaftar.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Section (Outside Table to prevent glitches) -->
    @foreach ($siswa as $s)
        <div class="modal fade" id="editSiswa{{ $s->nisn }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                    <div class="modal-header border-0 pb-0 pt-4 px-4">
                        <h5 class="modal-title fw-bold">Edit Data Siswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="/admin/siswa/{{ $s->nisn }}/update" method="POST">
                        @csrf
                        <div class="modal-body p-4">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">NISN (USERNAME)</label>
                                <input type="text" class="form-control bg-light border-0 fw-bold"
                                    value="{{ $s->nisn }}" disabled>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">NAMA LENGKAP</label>
                                <input type="text" name="nama" class="form-control bg-light border-0"
                                    value="{{ $s->nama }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">KELAS</label>
                                <input type="text" name="kelas" class="form-control bg-light border-0"
                                    value="{{ $s->kelas }}" required>
                            </div>
                            <div class="mb-0">
                                <label class="form-label small fw-bold text-muted">KATA SANDI BARU</label>
                                <input type="password" name="password" class="form-control bg-light border-0"
                                    placeholder="Biarkan kosong jika tetap">
                                <small class="text-muted mt-2 d-block"><i class="bi bi-info-circle me-1"></i> Kosongkan
                                    jika tidak ingin mengganti password.</small>
                            </div>
                        </div>
                        <div class="modal-footer border-0 p-4 pt-0">
                            <button type="button" class="btn btn-light rounded-pill px-4"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">Simpan
                                Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
