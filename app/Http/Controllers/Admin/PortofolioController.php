<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portofolio;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PortofolioController extends Controller
{
    public function index(Request $request)
    {
        $portofolios = Portofolio::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('nama_portofolio', 'like', "%{$search}%")
                        ->orWhere('nama_siswa', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('kategori'), function ($query) use ($request) {
                $query->where('kategori', $request->kategori);
            })
            ->latest('id_portofolio')
            ->paginate(8)
            ->withQueryString();

        return view('admin.porto', compact('portofolios'));
    }

    public function create()
    {
        return view('admin.createport');
    }

    public function edit($id)
    {
        $portofolio = Portofolio::findOrFail($id);

        return view('admin.editport', compact('portofolio'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'nama_siswa' => 'required|string|max:255',
            'kategori' => 'required|string',
            'teknologi' => 'nullable|string|max:255',
            'link_portofolio' => 'nullable|url|max:255',
            'deskripsi' => 'required',
            'gambar' => 'nullable|image|max:2048',
        ]);

        $gambar = null;

        if ($request->hasFile('gambar')) {
            $gambar = Str::random(20) . '.' . $request->file('gambar')->getClientOriginalExtension();
            $request->file('gambar')->move(public_path('image'), $gambar);
        }

        Portofolio::create([
            'nama_portofolio' => $request->judul,
            'nama_siswa' => $request->nama_siswa,
            'kategori' => $request->kategori,
            'teknologi' => $request->teknologi,
            'link_portofolio' => $request->link_portofolio,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambar,
        ]);

        return redirect()->route('admin.porto')->with('success', 'Portofolio berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $portofolio = Portofolio::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'nama_siswa' => 'required|string|max:255',
            'kategori' => 'required|string',
            'teknologi' => 'nullable|string|max:255',
            'link_portofolio' => 'nullable|url|max:255',
            'deskripsi' => 'required',
            'gambar' => 'nullable|image|max:2048',
        ]);

        $data = [
    'nama_portofolio' => $request->judul,
    'nama_siswa' => $request->nama_siswa,
    'kategori' => $request->kategori,
    'teknologi' => $request->teknologi,
    'link_portofolio' => $request->link_portofolio,
    'deskripsi' => $request->deskripsi,
];

        if ($request->hasFile('gambar')) {
            if ($portofolio->gambar && file_exists(public_path('image/' . $portofolio->gambar))) {
                unlink(public_path('image/' . $portofolio->gambar));
            }

            $gambar = Str::random(20) . '.' . $request->file('gambar')->getClientOriginalExtension();
            $request->file('gambar')->move(public_path('image'), $gambar);
            $data['gambar'] = $gambar;
        }

        $portofolio->update($data);

        return redirect()->route('admin.porto')->with('success', 'Portofolio berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $portofolio = Portofolio::findOrFail($id);

        if ($portofolio->gambar && file_exists(public_path('image/' . $portofolio->gambar))) {
            unlink(public_path('image/' . $portofolio->gambar));
        }

        $portofolio->delete();

        return redirect()->route('admin.porto')->with('success', 'Portofolio berhasil dihapus.');
    }
}
