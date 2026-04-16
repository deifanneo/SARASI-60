<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SiswaController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::post('/login', function (Request $request) {
    $username = $request->username;
    $password = $request->password;
    $role = $request->role;

    if ($role == 'siswa') {
        $user = DB::table('siswa')->where('nisn', $username)->first();
        if ($user && Hash::check($password, $user->password)) {
            session(['user_id' => $user->nisn, 'role' => 'siswa', 'nama' => $user->nama]);
            return redirect('/dashboard-siswa')->with('success', 'Selamat datang, ' . $user->nama);
        }
    } else {
        $user = DB::table('admin')->where('email', $username)->first();
        if ($user && Hash::check($password, $user->password)) {
            session(['user_id' => $user->id_admin, 'role' => 'admin', 'nama' => $user->nama_lengkap]);
            return redirect('/dashboard-admin')->with('success', 'Selamat datang, ' . $user->nama_lengkap);
        }
    }

    return back()->with('error', 'Username atau password salah!');
})->name('login');


Route::middleware(['web'])->group(function () {

    Route::middleware(['admin'])->group(function () {
        Route::get('/dashboard-admin', [AdminController::class, 'index']);
        Route::get('/admin/aspirasi', [AdminController::class, 'aspirasiIndex']);
        Route::get('/admin/aspirasi/{id}', [AdminController::class, 'aspirasiShow']);
        Route::post('/admin/aspirasi/{id}/tanggapi', [AdminController::class, 'tanggapi']);
        Route::get('/admin/aspirasi/{id}/delete', [AdminController::class, 'aspirasiDelete']);
        Route::delete('/admin/aspirasi/{id}', [AdminController::class, 'aspirasiDestroy']);

        Route::get('/admin/kategori', [AdminController::class, 'kategoriIndex']);
        Route::post('/admin/kategori', [AdminController::class, 'kategoriStore']);
        Route::post('/admin/kategori/{id}/update', [AdminController::class, 'kategoriUpdate']);
        Route::get('/admin/kategori/{id}/delete', [AdminController::class, 'kategoriDelete']);

        Route::get('/admin/siswa', [AdminController::class, 'siswaIndex']);
        Route::post('/admin/siswa', [AdminController::class, 'siswaStore']);
        Route::post('/admin/siswa/{nisn}/update', [AdminController::class, 'siswaUpdate']);
        Route::get('/admin/siswa/{nisn}/delete', [AdminController::class, 'siswaDelete']);
    });

    Route::middleware(['siswa'])->group(function () {
        Route::get('/dashboard-siswa', [SiswaController::class, 'index']);

        Route::get('/siswa/aspirasi/create', [SiswaController::class, 'create']);
        Route::post('/siswa/aspirasi', [SiswaController::class, 'store']);
        Route::get('/siswa/aspirasi/{id}/edit', [SiswaController::class, 'edit']);
        Route::post('/siswa/aspirasi/{id}/update', [SiswaController::class, 'update']);
        Route::get('/siswa/aspirasi/{id}/delete', [SiswaController::class, 'destroy']);
        Route::get('/siswa/aspirasi/{id}', [SiswaController::class, 'show']);
    });

    Route::get('/logout', function () {
        session()->flush();
        return redirect('/')->with('success', 'Berhasil keluar.');
    })->name('logout');
});
