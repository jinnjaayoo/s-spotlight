<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use App\Models\Info;
use App\Models\PengumpulanKarya;
use App\Models\Portofolio;

class DashboardController extends Controller
{
    public function index()
    {
        /*
         | Kategori informasi yang dihitung di Dashboard.
         | 'Agenda' SENGAJA dikecualikan dari total dan dari daftar
         | aktivitas terbaru. Data Agenda TIDAK dihapus dan tetap bisa
         | dikelola penuh lewat CRUD Info Umum.
         |
         | Pencocokan memakai LOWER(TRIM(...)) agar tahan terhadap
         | variasi penulisan ('Berita', 'berita ', 'BERITA').
         | Pola ini sama persis dengan yang sudah dipakai di
         | App\Http\Controllers\User\InfoController.
         */
        $kategoriDashboard = ['berita', 'pengumuman'];

        $infoDashboard = fn () => Info::query()
            ->whereRaw('LOWER(TRIM(kategori)) IN (?, ?)', $kategoriDashboard);

        $totalPortofolio = Portofolio::count();
        $totalGaleri = Galeri::count();
        $totalInfo = $infoDashboard()->count();
        $totalPengajuan = PengumpulanKarya::count();
        $totalPending = PengumpulanKarya::where('status', 'pending')->count();

        $activities = collect();

        foreach (Portofolio::latest('id_portofolio')->take(5)->get() as $item) {
            $activities->push([
                'icon' => 'porto.svg',
                'title' => 'Portofolio baru ditambahkan',
                'description' => $item->nama_portofolio,
                'time' => $item->created_at ?? $item->updated_at,
            ]);
        }

        foreach (Galeri::latest('id_galeri')->take(5)->get() as $item) {
            $activities->push([
                'icon' => 'gale.svg',
                'title' => 'Galeri baru ditambahkan',
                'description' => $item->judul,
                'time' => $item->created_at ?? $item->updated_at,
            ]);
        }

        foreach ($infoDashboard()->latest('id_info')->take(5)->get() as $item) {
            $activities->push([
                'icon' => 'infou.svg',
                'title' => $item->status === 'published'
                    ? 'Informasi baru dipublikasikan'
                    : 'Draft informasi baru dibuat',
                'description' => $item->judul,
                'time' => $item->created_at ?? $item->updated_at,
            ]);
        }

        foreach (PengumpulanKarya::latest('id_pengumpulan')->take(5)->get() as $item) {
            $activities->push([
                'icon' => 'pkarya.svg',
                'title' => 'Pengajuan karya: ' . $item->judul_karya,
                'description' => $item->nama_siswa . ' (' . $item->kelas . ') — Status: ' . ucfirst($item->status),
                'time' => $item->created_at,
            ]);
        }

        $activities = $activities
            ->sortByDesc(fn ($activity) => $activity['time'])
            ->take(8)
            ->values();

        return view('admin.dasbor', compact(
            'totalPortofolio',
            'totalGaleri',
            'totalInfo',
            'totalPengajuan',
            'totalPending',
            'activities'
        ));
    }
}
