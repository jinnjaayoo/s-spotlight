<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Info;

class InfoController extends Controller
{
    public function index()
{
    $query = Info::where('status', 'published')
        ->whereRaw("LOWER(TRIM(kategori)) IN ('berita', 'pengumuman')");

    // Search
    if (request()->filled('search')) {
        $search = request('search');

        $query->where(function ($q) use ($search) {
            $q->where('judul', 'like', "%{$search}%")
                ->orWhere('isi', 'like', "%{$search}%")
                ->orWhere('kategori', 'like', "%{$search}%");
        });
    }

    // Filter kategori
    $kategori = strtolower(trim(request('kategori', 'semua')));

    if (in_array($kategori, ['berita', 'pengumuman'])) {
        $query->whereRaw('LOWER(TRIM(kategori)) = ?', [$kategori]);
    }

    $infos = $query
        ->latest('id_info')
        ->get();

    return view('user.informasi.index', compact('infos'));
}

    /*
     | PERBAIKAN BUG.
     | Route 'user.informasi.show' (routes/web.php) memanggil method ini,
     | tetapi method-nya belum pernah ada sehingga tombol
     | "Baca Selengkapnya" menghasilkan error 500
     | (BadMethodCallException). View-nya sudah tersedia di
     | resources/views/user/informasi/show.blade.php.
     |
     | Aturan tampil dibuat sama persis dengan index(): hanya informasi
     | berstatus 'published' dan berkategori Berita atau Pengumuman,
     | supaya draft dan Agenda tidak bisa diakses lewat URL langsung.
     */
    public function show($id)
    {
        $info = Info::where('id_info', $id)
            ->where('status', 'published')
            ->whereRaw("LOWER(TRIM(kategori)) IN ('berita', 'pengumuman')")
            ->firstOrFail();

        return view('user.informasi.show', compact('info'));
    }
}
