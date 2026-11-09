<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GaleriController as AdminGaleriController;
use App\Http\Controllers\Admin\InfoController as AdminInfoController;
use App\Http\Controllers\Admin\LoginadminController;
use App\Http\Controllers\Admin\PortofolioController as AdminPortofolioController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\GaleriController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\InfoController;
use App\Http\Controllers\User\PortofolioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('user.beranda');
});

/*
|--------------------------------------------------------------------------
| HALAMAN FRONTEND
|--------------------------------------------------------------------------
*/

Route::get('/user/beranda', [HomeController::class, 'index'])
    ->name('user.beranda');

Route::get('/user/portofolio', [PortofolioController::class, 'index'])
    ->name('user.portofolio');

Route::get('/user/portofolio/{id}', [PortofolioController::class, 'show'])
    ->name('user.detailporto');

Route::post('/user/portofolio/{id}/love', [PortofolioController::class, 'love'])
    ->name('user.portofolio.love');

Route::get('/user/galeri', [GaleriController::class, 'index'])
    ->name('user.galeri');

Route::get('/user/infoumum', [InfoController::class, 'index'])
    ->name('user.infoumum');

Route::get('/user/informasi/{id}', [InfoController::class, 'show'])
    ->name('user.informasi.show');

Route::get('/user/profil', function () {
    return view('user.profil.index');
})->name('user.profil');
/*
|--------------------------------------------------------------------------
| ADMIN S'SPOTLIGHT
|--------------------------------------------------------------------------
*/

// LOGIN ADMIN (guest only)
Route::middleware('guest:admin')->group(function () {
    Route::get('/admin/login', [LoginadminController::class, 'showLoginForm'])
        ->name('admin.login');

    Route::post('/admin/login', [LoginadminController::class, 'login'])
        ->name('admin.login.submit');
});

Route::post('/admin/logout', [LoginadminController::class, 'logout'])
    ->middleware('auth:admin')
    ->name('admin.logout');

// SEMUA HALAMAN ADMIN LAINNYA WAJIB LOGIN SEBAGAI ADMIN
Route::middleware('auth:admin')->group(function () {

    // DASHBOARD
    Route::get('/admin/dash', [DashboardController::class, 'index'])
        ->name('admin.dasbor');

    // PORTOFOLIO
    Route::get('/admin/porto', [AdminPortofolioController::class, 'index'])
        ->name('admin.porto');

    Route::get('/admin/createporto', [AdminPortofolioController::class, 'create'])
        ->name('admin.createport');

    Route::post('/admin/porto', [AdminPortofolioController::class, 'store'])
        ->name('admin.porto.store');

    Route::get('/admin/porto/{id}/edit', [AdminPortofolioController::class, 'edit'])
        ->name('admin.porto.edit');

    Route::put('/admin/porto/{id}', [AdminPortofolioController::class, 'update'])
        ->name('admin.porto.update');

    Route::delete('/admin/porto/{id}', [AdminPortofolioController::class, 'destroy'])
        ->name('admin.porto.destroy');

    // GALERI
    Route::get('/admin/galeri', [AdminGaleriController::class, 'index'])
        ->name('admin.galeri');

    Route::get('/admin/creategaleri', [AdminGaleriController::class, 'create'])
        ->name('admin.creategaleri');

    Route::post('/admin/galeri', [AdminGaleriController::class, 'store'])
        ->name('admin.galeri.store');

    Route::get('/admin/galeri/{id}/edit', [AdminGaleriController::class, 'edit'])
        ->name('admin.galeri.edit');

    Route::put('/admin/galeri/{id}', [AdminGaleriController::class, 'update'])
        ->name('admin.galeri.update');

    Route::delete('/admin/galeri/{id}', [AdminGaleriController::class, 'destroy'])
        ->name('admin.galeri.destroy');

    // PROFIL ADMIN
    Route::get('/admin/profile', [AdminProfileController::class, 'edit'])
        ->name('admin.profile');

    Route::put('/admin/profile', [AdminProfileController::class, 'update'])
        ->name('admin.profile.update');

    // INFO UMUM
    Route::get('/admin/info', [AdminInfoController::class, 'index'])
        ->name('admin.info');

    Route::get('/admin/createinfo', [AdminInfoController::class, 'create'])
        ->name('admin.createinfo');

    Route::post('/admin/info', [AdminInfoController::class, 'store'])
        ->name('admin.info.store');

    Route::get('/admin/info/{id}/edit', [AdminInfoController::class, 'edit'])
        ->name('admin.info.edit');

    Route::put('/admin/info/{id}', [AdminInfoController::class, 'update'])
        ->name('admin.info.update');

    Route::delete('/admin/info/{id}', [AdminInfoController::class, 'destroy'])
        ->name('admin.info.destroy');
});

/*
|--------------------------------------------------------------------------
| BAWAAN LARAVEL AUTH (siswa/pengguna biasa, jika dipakai)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
