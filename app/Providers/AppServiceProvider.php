<?php

namespace App\Providers;

use App\Models\PengumpulanKarya;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Bagikan jumlah pengajuan pending ke semua view admin untuk notifikasi/indikator badge
        View::composer('admin.*', function ($view) {
            try {
                if (Schema::hasTable('pengumpulan_karya')) {
                    $pendingCount = PengumpulanKarya::where('status', 'pending')->count();
                    $view->with('pendingSubmissionsCount', $pendingCount);
                }
            } catch (\Throwable $e) {
                // Abaikan jika database belum siap
            }
        });
    }
}
