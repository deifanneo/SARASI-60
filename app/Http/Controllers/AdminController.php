<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $hitungan = [
            'total' => DB::table('aspirasi')->count(),
            'diajukan' => DB::table('aspirasi')->where('status', 'Diajukan')->count(),
            'diproses' => DB::table('aspirasi')->where('status', 'Diproses')->count(),
            'selesai' => DB::table('aspirasi')->where('status', 'Selesai')->count(),
        ];

        $data_terbaru = DB::table('aspirasi')
            ->join('siswa', 'aspirasi.nisn', '=', 'siswa.nisn')
            ->join('kategori', 'aspirasi.id_kategori', '=', 'kategori.id_kategori')
            ->select('aspirasi.*', 'siswa.nama', 'kategori.nama_kategori')
            ->orderBy('tanggal_input', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', ['stats' => $hitungan, 'latest_aspirasi' => $data_terbaru]);
    }

    public function aspirasiIndex(Request $request)
    {
        $query = DB::table('aspirasi')
            ->join('siswa', 'aspirasi.nisn', '=', 'siswa.nisn')
            ->join('kategori', 'aspirasi.id_kategori', '=', 'kategori.id_kategori')
            ->select('aspirasi.*', 'siswa.nama', 'kategori.nama_kategori');

        $status = $request->query('status');
        $search = $request->query('search');
        $tanggal = $request->query('tanggal');

        if (in_array($status, ['Diajukan', 'Diproses', 'Selesai'])) {
            $query->where('aspirasi.status', $status);
        }

        if ($search) {
            $query->where('siswa.nama', 'LIKE', '%' . $search . '%');
        }

        if ($tanggal) {
            $query->whereDate('aspirasi.tanggal_input', $tanggal);
        }

        $aspirasi = $query->orderBy('tanggal_input', 'desc')->get();

        return view('admin.aspirasi.index', compact('aspirasi'));
    }

    public function aspirasiShow($id)
    {
        $aspirasi = DB::table('aspirasi')
            ->join('siswa', 'aspirasi.nisn', '=', 'siswa.nisn')
            ->join('kategori', 'aspirasi.id_kategori', '=', 'kategori.id_kategori')
            ->select('aspirasi.*', 'siswa.nama', 'kategori.nama_kategori')
            ->where('id_aspirasi', $id)
            ->first();

        if (!$aspirasi) return redirect('/admin/aspirasi')->with('error', 'Aspirasi tidak ditemukan.');

        $umpan_balik = DB::table('umpan_balik')
            ->join('admin', 'umpan_balik.id_admin', '=', 'admin.id_admin')
            ->where('id_aspirasi', $id)
            ->select('umpan_balik.*', 'admin.nama_lengkap')
            ->get();

        return view('admin.aspirasi.show', compact('aspirasi', 'umpan_balik'));
    }

    public function tanggapi(Request $request, $id)
    {
        $request->validate([
            'tanggapan' => 'required',
            'status' => 'required|in:Diproses,Selesai'
        ]);

        DB::table('umpan_balik')->insert([
            'id_aspirasi' => $id,
            'id_admin' => session('user_id'),
            'tanggapan' => $request->tanggapan,
            'tanggal_tanggapan' => now()
        ]);

        DB::table('aspirasi')->where('id_aspirasi', $id)->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Tanggapan berhasil dikirim.');
    }

    public function aspirasiDestroy($id)
    {
        $aspirasi = DB::table('aspirasi')->where('id_aspirasi', $id)->first();

        if (!$aspirasi) {
            return redirect('/admin/aspirasi')->with('error', 'Aspirasi tidak ditemukan.');
        }

        if ($aspirasi->status !== 'Selesai') {
            return redirect('/admin/aspirasi')->with('error', 'Hanya aspirasi dengan status Selesai yang dapat dihapus.');
        }

        DB::table('aspirasi')->where('id_aspirasi', $id)->delete();

        return redirect('/admin/aspirasi')->with('success', 'Aspirasi berhasil dihapus.');
    }

    public function aspirasiDelete($id)
    {
        $aspirasi = DB::table('aspirasi')->where('id_aspirasi', $id)->first();

        if (!$aspirasi) {
            return redirect('/admin/aspirasi')->with('error', 'Aspirasi tidak ditemukan.');
        }

        if ($aspirasi->status !== 'Selesai') {
            return redirect('/admin/aspirasi')->with('error', 'Hanya aspirasi dengan status Selesai yang dapat dihapus.');
        }

        DB::table('aspirasi')->where('id_aspirasi', $id)->delete();

        return redirect('/admin/aspirasi')->with('success', 'Aspirasi berhasil dihapus.');
    }

    public function kategoriIndex()
    {
        $kategori = DB::table('kategori')->get();
        return view('admin.kategori.index', compact('kategori'));
    }

    public function kategoriStore(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|max:50'
        ]);

        DB::table('kategori')->insert(['nama_kategori' => $request->nama_kategori]);
        return back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function kategoriUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|max:50'
        ]);

        DB::table('kategori')->where('id_kategori', $id)->update([
            'nama_kategori' => $request->nama_kategori
        ]);

        return back()->with('success', 'Kategori berhasil diperbarui.');
    }

    public function kategoriDelete($id)
    {
        DB::table('kategori')->where('id_kategori', $id)->delete();
        return back()->with('success', 'Kategori berhasil dihapus.');
    }

    public function siswaIndex()
    {
        $siswa = DB::table('siswa')->orderBy('created_at', 'desc')->get();
        return view('admin.siswa.index', compact('siswa'));
    }

    public function siswaStore(Request $request)
    {
        $request->validate([
            'nisn' => 'required|unique:siswa,nisn',
            'nama' => 'required',
            'kelas' => 'required',
            'password' => 'required|min:6'
        ]);

        DB::table('siswa')->insert([
            'nisn' => $request->nisn,
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'created_at' => now()
        ]);

        return redirect('/admin/siswa')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function siswaUpdate(Request $request, $nisn)
    {
        $request->validate([
            'nama' => 'required',
            'kelas' => 'required',
        ]);

        $updateData = [
            'nama' => $request->nama,
            'kelas' => $request->kelas,
        ];

        if ($request->password) {
            $updateData['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        DB::table('siswa')->where('nisn', $nisn)->update($updateData);
        return back()->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function siswaDelete($nisn)
    {
        DB::table('siswa')->where('nisn', $nisn)->delete();
        return back()->with('success', 'Data siswa berhasil dihapus.');
    }
}
