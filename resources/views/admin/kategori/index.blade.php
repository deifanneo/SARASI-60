@extends('layouts.dashboard')

@section('title', 'Manajemen Kategori')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold">Manajemen Kategori</h3>
</div>

<div class="row">
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">Tambah Kategori Baru</h6>
            </div>
            <div class="card-body">
                <form action="/admin/kategori" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Kategori</label>
                        <input type="text" name="nama_kategori" class="form-control" placeholder="Contoh: Infrastruktur" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Simpan Kategori</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">ID</th>
                                <th>Nama Kategori</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($kategori) > 0)
                                @foreach($kategori as $k)
                                <tr>
                                    <td class="ps-4 text-muted">{{ $k->id_kategori }}</td>
                                    <td><strong>{{ $k->nama_kategori }}</strong></td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-outline-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $k->id_kategori }}" title="Edit Kategori">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger shadow-sm ms-1" onclick="confirmDelete('/admin/kategori/{{ $k->id_kategori }}/delete', 'Hapus kategori ini? Data yang terkait bisa saja hilang.')" title="Hapus Kategori">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">Belum ada kategori.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach($kategori as $k)
<!-- Modal Edit Kategori -->
<div class="modal fade" id="editModal{{ $k->id_kategori }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Edit Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/admin/kategori/{{ $k->id_kategori }}/update" method="POST">
                @csrf
                <div class="modal-body py-4">
                    <div class="mb-2">
                        <label class="form-label small fw-bold text-muted">Nama Kategori</label>
                        <input type="text" name="nama_kategori" class="form-control form-control-lg fs-6" value="{{ $k->nama_kategori }}" required>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection
