<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengumpulan_karya', function (Blueprint $table) {
            $table->id('id_pengumpulan');
            $table->string('nama_siswa');
            $table->string('kelas', 50);
            $table->string('judul_karya');
            $table->string('kategori', 50);
            $table->longText('deskripsi');
            $table->string('gambar');
            $table->string('status', 20)->default('pending'); // pending, approved, rejected
            $table->string('status_publikasi', 20)->default('belum_dipublikasi'); // belum_dipublikasi, dipublikasikan
            $table->unsignedBigInteger('id_portofolio')->nullable();
            $table->foreign('id_portofolio')->references('id_portofolio')->on('portofolio')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengumpulan_karya');
    }
};
