<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('info_umum', function (Blueprint $table) {
            $table->id('id_info');
            $table->string('judul');
            $table->longText('isi')->nullable();
            $table->string('gambar')->nullable();
            $table->string('kategori')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('status')->default('draft');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('info_umum');
    }
};
