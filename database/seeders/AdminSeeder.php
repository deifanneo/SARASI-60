<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('admin')->insert([
            [
                'email' => 'admin@admin.com',
                'password' => Hash::make('passwordd'),
                'nama_lengkap' => 'Administrator Utama',
                'level' => 'admin'
            ],
            [
                'email' => 'petugas@admin.com',
                'password' => Hash::make('password'),
                'nama_lengkap' => 'Petugas Sarpras',
                'level' => 'petugas'
            ]
        ]);
    }
}
