@extends('layouts.dashboard')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h3 class="fw-bold mb-0">Aspirasi Saya</h3>
        <p class="text-muted">Pantau status aspirasi yang telah kamu sampaikan.</p>
    </div>
    <a href="/siswa/aspirasi/create" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Buat Aspirasi</a>
</div>

<div class="row g-4">
    @if(count($aspirasi) > 0)
        @foreach($aspirasi as $a)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm border-top border-4 border-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge bg-secondary">{{ $a->nama_kategori }}</span>
                        @php
                            $badge = 'bg-warning';
                            if($a->status == 'Diproses') $badge = 'bg-info';
                            if($a->status == 'Selesai') $badge = 'bg-success';
                        @endphp
                        <span class="badge {{ $badge }}">{{ $a->status }}</span>
                    </div>
                    <h5 class="fw-bold mb-2">{{ $a->judul }}</h5>
                    <p class="text-muted small mb-3 text-truncate-3" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                        {{ $a->isi }}
                    </p>
                    
                    <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                        <small class="text-muted">{{ date('d M Y', strtotime($a->tanggal_input)) }}</small>
                        <div>
                            @if($a->status == 'Diajukan')
                            <a href="/siswa/aspirasi/{{ $a->id_aspirasi }}/edit" class="btn btn-sm btn-outline-primary me-1">Edit</a>
                            <button type="button" onclick="confirmDelete('/siswa/aspirasi/{{ $a->id_aspirasi }}/delete', 'Hapus aspirasi ini? Tidak dapat dikembalikan.')" class="btn btn-sm btn-outline-danger me-1">Hapus</button>
                            @endif
                            <a href="/siswa/aspirasi/{{ $a->id_aspirasi }}" class="btn btn-sm btn-light border">Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @else
        <div class="col-12">
            <div class="card p-5 text-center text-muted">
                <i class="bi bi-chat-left-dots display-1 mb-3 opacity-25"></i>
                <h5>Belum ada aspirasi.</h5>
                <p>Aspirasi kamu akan muncul di sini setelah kamu mengirimkannya.</p>
                <div class="mt-3">
                    <a href="/siswa/aspirasi/create" class="btn btn-primary">Kirim Aspirasi Sekarang</a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
