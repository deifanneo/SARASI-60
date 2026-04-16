<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aspirasi', function (Blueprint $table) {
            $table->id('id_aspirasi');
            $table->string('nisn', 10);
            $table->unsignedBigInteger('id_kategori');
            $table->string('judul', 100);
            $table->text('isi');
            $table->string('lokasi', 100)->nullable();
            $table->dateTime('tanggal_input')->useCurrent();
            $table->string('foto', 255)->nullable();
            $table->enum('status', ['Diajukan', 'Diproses', 'Selesai'])->default('Diajukan');

            $table->foreign('nisn')->references('nisn')->on('siswa')->onDelete('cascade');
            $table->foreign('id_kategori')->references('id_kategori')->on('kategori')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aspirasi');
    }
};
