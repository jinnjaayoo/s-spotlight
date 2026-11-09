<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portofolio', function (Blueprint $table) {
            $table->id('id_portofolio');
            $table->string('nama_portofolio');
            $table->string('nama_siswa');
            $table->string('kategori');
            $table->longText('deskripsi')->nullable();
            $table->string('gambar')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portofolio');
    }
};
