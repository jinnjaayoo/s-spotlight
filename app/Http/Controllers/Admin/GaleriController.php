<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GaleriController extends Controller
{
    public function index(Request $request)
    {
        $galeris = Galeri::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('judul', 'like', '%'.$request->search.'%');
            })
            ->latest('id_galeri')
            ->paginate(9)
            ->withQueryString();

        return view('admin.galeri', compact('galeris'));
    }

    public function create()
    {
        return view('admin.creategaleri');
    }

    public function edit($id)
    {
        $galeri = Galeri::findOrFail($id);

        return view('admin.editgaleri', compact('galeri'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'gambar' => 'nullable|image|max:2048',
        ]);

        $gambar = null;

        if ($request->hasFile('gambar')) {
            $gambar = Str::random(20).'.'.$request->file('gambar')->getClientOriginalExtension();
            $request->file('gambar')->move(public_path('image'), $gambar);
        }

        Galeri::create([
            'judul' => $request->judul,
            'gambar' => $gambar,
        ]);

        return redirect()->route('admin.galeri')->with('success', 'Galeri berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $galeri = Galeri::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'gambar' => 'nullable|image|max:2048',
        ]);

        $data = ['judul' => $request->judul];

        if ($request->hasFile('gambar')) {
            if ($galeri->gambar && file_exists(public_path('image/'.$galeri->gambar))) {
                unlink(public_path('image/'.$galeri->gambar));
            }

            $gambar = Str::random(20).'.'.$request->file('gambar')->getClientOriginalExtension();
            $request->file('gambar')->move(public_path('image'), $gambar);
            $data['gambar'] = $gambar;
        }

        $galeri->update($data);

        return redirect()->route('admin.galeri')->with('success', 'Galeri berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $galeri = Galeri::findOrFail($id);

        if ($galeri->gambar && file_exists(public_path('image/'.$galeri->gambar))) {
            unlink(public_path('image/'.$galeri->gambar));
        }

        $galeri->delete();

        return redirect()->route('admin.galeri')->with('success', 'Galeri berhasil dihapus.');
    }
}
