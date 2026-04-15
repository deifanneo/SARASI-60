<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kategori')->insert([
            ['nama_kategori' => 'Sarana Belajar'],
            ['nama_kategori' => 'Kebersihan'],
            ['nama_kategori' => 'Fasilitas Umum'],
            ['nama_kategori' => 'Keamanan'],
            ['nama_kategori' => 'Kesehatan'],
        ]);
    }
}
