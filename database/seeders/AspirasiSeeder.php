<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AspirasiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('aspirasi')->insert([
            [
                'nisn' => '1234567890',
                'id_kategori' => 1,
                'judul' => 'Kursi Rusak di Kelas XII RPL 1',
                'isi' => 'Ada beberapa kursi yang kakinya goyang dan membahayakan siswa saat belajar. Mohon segera diperbaiki atau diganti.',
                'lokasi' => 'Gedung A, Lantai 2',
                'foto' => 'aspirasi/kursi_rusak.png',
                'status' => 'Diajukan',
                'tanggal_input' => now(),
            ],
            [
                'nisn' => '0987654321',
                'id_kategori' => 2,
                'judul' => 'Lantai Koridor Kotor',
                'isi' => 'Lantai di koridor depan lab komputer sangat lengket dan kotor, sepertinya ada tumpahan minuman semalam.',
                'lokasi' => 'Depan Lab Komputer 1',
                'foto' => null,
                'status' => 'Diproses',
                'tanggal_input' => now(),
            ]
        ]);
    }
}
