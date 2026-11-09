<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portofolio', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('galeri', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('info_umum', function (Blueprint $table) {
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('portofolio', function (Blueprint $table) {
            $table->dropTimestamps();
        });

        Schema::table('galeri', function (Blueprint $table) {
            $table->dropTimestamps();
        });

        Schema::table('info_umum', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
};
