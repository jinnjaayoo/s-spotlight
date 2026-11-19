<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengumpulan_karya', function (Blueprint $table) {
            // Soft delete: data pengajuan tidak pernah benar-benar hilang dari tabel,
            // sehingga tetap bisa dipakai sebagai data laporan.
            $table->softDeletes();

            // Index untuk kebutuhan filter/rekap laporan (per status, kategori, kelas, tanggal).
            $table->index('status');
            $table->index('status_publikasi');
            $table->index('kategori');
            $table->index('kelas');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::table('pengumpulan_karya', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['status_publikasi']);
            $table->dropIndex(['kategori']);
            $table->dropIndex(['kelas']);
            $table->dropIndex(['created_at']);
            $table->dropSoftDeletes();
        });
    }
};
