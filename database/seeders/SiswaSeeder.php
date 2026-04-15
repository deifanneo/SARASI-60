<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('siswa')->insert([
            [
                'nisn' => '1234567890',
                'nama' => 'Budi Santoso',
                'kelas' => 'XII RPL 1',
                'password' => Hash::make('password'),
                'created_at' => now(),
            ],
            [
                'nisn' => '0987654321',
                'nama' => 'Siti Aminah',
                'kelas' => 'XI TKJ 2',
                'password' => Hash::make('password'),
                'created_at' => now(),
            ]
        ]);
    }
}
