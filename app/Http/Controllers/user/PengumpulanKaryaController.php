<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PengumpulanKarya;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PengumpulanKaryaController extends Controller
{
    public function create()
    {
        return view('user.pengajuan.create');
    }

    public function success()
    {
        return view('user.pengajuan.success');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'judul_karya' => 'required|string|max:255',
            'kategori' => 'required|in:Web,Apk,Desain,Gambar',
            'deskripsi' => 'required|string|max:5000',
            'gambar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'nama_siswa.required' => 'Nama siswa wajib diisi.',
            'kelas.required' => 'Kelas wajib diisi.',
            'judul_karya.required' => 'Judul karya wajib diisi.',
            'kategori.required' => 'Kategori karya wajib dipilih.',
            'kategori.in' => 'Kategori karya tidak valid.',
            'deskripsi.required' => 'Deskripsi karya wajib diisi.',
            'gambar.required' => 'Gambar karya wajib diunggah.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Gambar harus berformat JPG, JPEG, PNG, atau WEBP.',
            'gambar.max' => 'Ukuran gambar maksimal 2 MB.',
        ]);

        // Pola penyimpanan sama dengan CRUD admin: nama acak, disimpan di public/image
        $gambar = null;

        try {
            $gambar = Str::random(20) . '.' . $request->file('gambar')->getClientOriginalExtension();
            $request->file('gambar')->move(public_path('image'), $gambar);

            $pengumpulan = PengumpulanKarya::create([
                'nama_siswa' => $request->nama_siswa,
                'kelas' => $request->kelas,
                'judul_karya' => $request->judul_karya,
                'kategori' => $request->kategori,
                'deskripsi' => $request->deskripsi,
                'gambar' => $gambar,
                'status' => 'pending',
                'status_publikasi' => 'belum_dipublikasi',
            ]);
        } catch (\Throwable $e) {
            report($e);

            // Bersihkan berkas yang sempat tersimpan agar tidak jadi file yatim
            if ($gambar && file_exists(public_path('image/' . $gambar))) {
                @unlink(public_path('image/' . $gambar));
            }

            return back()
                ->withInput()
                ->with('toast_error', 'Pengajuan gagal disimpan. Silakan coba lagi beberapa saat.');
        }

        return redirect()
            ->route('user.pengajuan.sukses')
            ->with('success', 'Karya berhasil dikirim!')
            ->with('toast_success', 'Pengajuan karya berhasil dikirim dan menunggu peninjauan admin.')
            ->with('submitted_karya', [
                'judul' => $pengumpulan->judul_karya,
                'nama' => $pengumpulan->nama_siswa,
                'kelas' => $pengumpulan->kelas,
                'kategori' => $pengumpulan->kategori,
            ]);
    }
}
