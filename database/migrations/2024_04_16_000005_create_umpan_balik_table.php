<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('umpan_balik', function (Blueprint $table) {
            $table->id('id_umpan_balik');
            $table->unsignedBigInteger('id_aspirasi');
            $table->unsignedBigInteger('id_admin');
            $table->text('tanggapan');
            $table->dateTime('tanggal_tanggapan')->useCurrent();

            $table->foreign('id_aspirasi')->references('id_aspirasi')->on('aspirasi')->onDelete('cascade');
            $table->foreign('id_admin')->references('id_admin')->on('admin')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('umpan_balik');
    }
};
