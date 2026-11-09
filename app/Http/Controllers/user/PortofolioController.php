<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Portofolio;

class PortofolioController extends Controller
{
    public function index()
{
    $query = Portofolio::query();

    // SEARCH
    if (request()->filled('search')) {
        $search = request('search');

        $query->where(function ($q) use ($search) {
            $q->where('nama_portofolio', 'like', "%{$search}%")
                ->orWhere('nama_siswa', 'like', "%{$search}%")
                ->orWhere('deskripsi', 'like', "%{$search}%");
        });
    }

    // FILTER KATEGORI
    if (
        request()->filled('category') &&
        request('category') !== 'Semua'
    ) {
        $query->where('kategori', request('category'));
    }

    $portofolios = $query
        ->latest('id_portofolio')
        ->get();

    return view(
        'user.portofolio.index',
        compact('portofolios')
    );
}

public function show($id)
{
    $portofolio = Portofolio::findOrFail($id);

    $karyaTerkait = Portofolio::where('kategori', $portofolio->kategori)
        ->where('id_portofolio', '!=', $portofolio->id_portofolio)
        ->latest('id_portofolio')
        ->take(4)
        ->get();

    return view('user.portofolio.show', compact('portofolio', 'karyaTerkait'));
}

    public function love($id)
    {
        $portofolio = Portofolio::findOrFail($id);

        $portofolio->increment('jumlah_love');

        return back();
    }
}
