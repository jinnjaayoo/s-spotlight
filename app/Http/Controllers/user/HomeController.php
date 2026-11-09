<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use App\Models\Info;
use App\Models\Portofolio;

class HomeController extends Controller
{
    public function index()
    {
        $portofolios = Portofolio::latest('id_portofolio')->take(4)->get();
        $galeris = Galeri::latest('id_galeri')->take(4)->get();
        $infos = Info::where('status', 'published')->latest('id_info')->take(3)->get();

        return view('user.beranda', compact('portofolios', 'galeris', 'infos'));
    }
}
