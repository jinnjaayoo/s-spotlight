<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Info;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InfoController extends Controller
{
    public function index(Request $request)
    {
        $infos = Info::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('judul', 'like', '%'.$request->search.'%');
            })
            ->when($request->filled('kategori'), function ($query) use ($request) {
                $query->where('kategori', $request->kategori);
            })
            ->latest('id_info')
            ->paginate(8)
            ->withQueryString();

        return view('admin.info', compact('infos'));
    }

    public function create()
    {
        return view('admin.createinfo');
    }

    public function edit($id)
    {
        $info = Info::findOrFail($id);

        return view('admin.editinfo', compact('info'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'tanggal' => 'nullable|date',
            'status' => 'required|in:draft,published',
            'isi' => 'nullable|string',
            'gambar' => 'nullable|image|max:2048',
        ]);

        $gambar = null;

        if ($request->hasFile('gambar')) {
            $gambar = Str::random(20).'.'.$request->file('gambar')->getClientOriginalExtension();
            $request->file('gambar')->move(public_path('image'), $gambar);
        }

        Info::create([
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'tanggal' => $request->tanggal,
            'status' => $request->status,
            'isi' => $request->isi,
            'gambar' => $gambar,
        ]);

        return redirect()->route('admin.info')->with('success', 'Informasi berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $info = Info::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'tanggal' => 'nullable|date',
            'status' => 'required|in:draft,published',
            'isi' => 'nullable|string',
            'gambar' => 'nullable|image|max:2048',
        ]);

        $data = [
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'tanggal' => $request->tanggal,
            'status' => $request->status,
            'isi' => $request->isi,
        ];

        if ($request->hasFile('gambar')) {
            if ($info->gambar && file_exists(public_path('image/'.$info->gambar))) {
                unlink(public_path('image/'.$info->gambar));
            }

            $gambar = Str::random(20).'.'.$request->file('gambar')->getClientOriginalExtension();
            $request->file('gambar')->move(public_path('image'), $gambar);
            $data['gambar'] = $gambar;
        }

        $info->update($data);

        return redirect()->route('admin.info')->with('success', 'Informasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $info = Info::findOrFail($id);

        if ($info->gambar && file_exists(public_path('image/'.$info->gambar))) {
            unlink(public_path('image/'.$info->gambar));
        }

        $info->delete();

        return redirect()->route('admin.info')->with('success', 'Informasi berhasil dihapus.');
    }
}
