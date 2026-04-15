@extends('layouts.dashboard')

@section('title', 'Manajemen Admin')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold">Manajemen Akun Admin</h3>
    <p class="text-muted">Tambah dan kelola akun administrator atau petugas sistem.</p>
</div>

<div class="row">
    <div class="col-lg-4">
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-0">
                <h6 class="mb-0 fw-bold">Tambah Akun Baru</h6>
            </div>
            <div class="card-body">
                <form action="/admin/users" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Username / Email</label>
                        <input type="text" name="username" class="form-control bg-light border-0" placeholder="admin@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control bg-light border-0" placeholder="Contoh: Ahmad Subardjo" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Kata Sandi</label>
                        <input type="password" name="password" class="form-control bg-light border-0" placeholder="Min. 6 karakter" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Level Akses</label>
                        <select name="level" class="form-select bg-light border-0" required>
                            <option value="admin">Administrator (Full Access)</option>
                            <option value="petugas">Petugas (Feedback Only)</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2 mt-2">Daftarkan Akun</button>
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
                                <th class="ps-4 py-3 border-0">Nama Lengkap</th>
                                <th class="py-3 border-0">Username</th>
                                <th class="py-3 border-0">Level</th>
                                <th class="text-end pe-4 py-3 border-0">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($admins as $admin)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3 text-primary">
                                            <i class="bi bi-person-fill"></i>
                                        </div>
                                        <strong>{{ $admin->nama_lengkap }}</strong>
                                    </div>
                                </td>
                                <td>{{ $admin->username }}</td>
                                <td>
                                    <span class="badge {{ $admin->level == 'admin' ? 'bg-indigo text-white' : 'bg-teal text-white' }}" 
                                          style="background-color: {{ $admin->level == 'admin' ? '#6610f2' : '#20c997' }}">
                                        {{ ucfirst($admin->level) }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <button class="btn btn-sm btn-link text-muted" disabled><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-sm btn-link text-danger" disabled><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">Belum ada akun terdaftar.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
