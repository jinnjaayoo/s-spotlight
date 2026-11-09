<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Galeri;

class GaleriController extends Controller
{
    public function index()
    {
        $query = Galeri::query();

        if (request()->filled('search')) {
            $search = request('search');
            $query->where('judul', 'like', "%{$search}%");
        }

        $galeris = $query
    ->latest('id_galeri')
    ->paginate(12)
    ->withQueryString();

        return view('user.galeri.index', compact('galeris'));
    }
}
