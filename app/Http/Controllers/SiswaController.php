<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    public function index()
    {
        $aspirasi = DB::table('aspirasi')
            ->join('kategori', 'aspirasi.id_kategori', '=', 'kategori.id_kategori')
            ->where('nisn', session('user_id'))
            ->select('aspirasi.*', 'kategori.nama_kategori')
            ->orderBy('tanggal_input', 'desc')
            ->get();

        return view('siswa.dashboard', compact('aspirasi'));
    }

    public function create()
    {
        $kategori = DB::table('kategori')->get();
        return view('siswa.aspirasi.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required',
            'judul' => 'required|max:100',
            'isi' => 'required',
            'lokasi' => 'nullable|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $path_foto = null;
        if ($request->hasFile('foto')) {
            $path_foto = $request->file('foto')->store('aspirasi', 'public');
        }

        DB::table('aspirasi')->insert([
            'nisn' => session('user_id'),
            'id_kategori' => $request->id_kategori,
            'judul' => $request->judul,
            'isi' => $request->isi,
            'lokasi' => $request->lokasi,
            'foto' => $path_foto,
            'status' => 'Diajukan',
            'tanggal_input' => now()
        ]);

        return redirect('/dashboard-siswa')->with('success', 'Aspirasi berhasil dikirim!');
    }

    public function edit($id)
    {
        $aspirasi = DB::table('aspirasi')
            ->where('id_aspirasi', $id)
            ->where('nisn', session('user_id'))
            ->where('status', 'Diajukan')
            ->first();

        if (!$aspirasi) {
            return redirect('/dashboard-siswa')->with('error', 'Aspirasi tidak dapat diedit atau tidak ditemukan.');
        }

        $kategori = DB::table('kategori')->get();
        return view('siswa.aspirasi.edit', compact('aspirasi', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $aspirasi = DB::table('aspirasi')
            ->where('id_aspirasi', $id)
            ->where('nisn', session('user_id'))
            ->where('status', 'Diajukan')
            ->first();

        if (!$aspirasi) {
            return redirect('/dashboard-siswa')->with('error', 'Aspirasi tidak dapat diedit.');
        }

        $request->validate([
            'id_kategori' => 'required',
            'judul' => 'required|max:100',
            'isi' => 'required',
            'lokasi' => 'nullable|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $update_data = [
            'id_kategori' => $request->id_kategori,
            'judul' => $request->judul,
            'isi' => $request->isi,
            'lokasi' => $request->lokasi,
        ];

        if ($request->hasFile('foto')) {
            $update_data['foto'] = $request->file('foto')->store('aspirasi', 'public');
        }

        DB::table('aspirasi')->where('id_aspirasi', $id)->update($update_data);

        return redirect('/dashboard-siswa')->with('success', 'Aspirasi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $aspirasi = DB::table('aspirasi')
            ->where('id_aspirasi', $id)
            ->where('nisn', session('user_id'))
            ->where('status', 'Diajukan')
            ->first();

        if (!$aspirasi) {
            return redirect('/dashboard-siswa')->with('error', 'Aspirasi tidak dapat dihapus.');
        }

        DB::table('aspirasi')->where('id_aspirasi', $id)->delete();
        return redirect('/dashboard-siswa')->with('success', 'Aspirasi berhasil dihapus.');
    }

    public function show($id)
    {
        $aspirasi = DB::table('aspirasi')
            ->join('kategori', 'aspirasi.id_kategori', '=', 'kategori.id_kategori')
            ->where('id_aspirasi', $id)
            ->where('nisn', session('user_id'))
            ->select('aspirasi.*', 'kategori.nama_kategori')
            ->first();

        if (!$aspirasi) return redirect('/dashboard-siswa')->with('error', 'Aspirasi tidak ditemukan.');

        $umpan_balik = DB::table('umpan_balik')
            ->join('admin', 'umpan_balik.id_admin', '=', 'admin.id_admin')
            ->where('id_aspirasi', $id)
            ->select('umpan_balik.*', 'admin.nama_lengkap')
            ->get();

        return view('siswa.aspirasi.show', compact('aspirasi', 'umpan_balik'));
    }
}
