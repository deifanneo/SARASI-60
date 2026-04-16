<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->id('id_admin');
            $table->string('email', 100);
            $table->string('password');
            $table->string('nama_lengkap', 100);
            $table->enum('level', ['admin', 'petugas'])->default('admin');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin');
    }
};
