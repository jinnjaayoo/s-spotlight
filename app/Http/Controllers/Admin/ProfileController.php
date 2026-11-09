<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        $admin = Auth::guard('admin')->user();

        return view('admin.profiladmin', compact('admin'));
    }

    public function update(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('admins', 'email')->ignore($admin->id)],
            'keterangan' => 'nullable|string|max:1000',
            'foto' => 'nullable|image|max:2048',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'keterangan' => $request->keterangan,
        ];

        if ($request->hasFile('foto')) {
            if ($admin->foto && file_exists(public_path('image/'.$admin->foto))) {
                unlink(public_path('image/'.$admin->foto));
            }

            $foto = Str::random(20).'.'.$request->file('foto')->getClientOriginalExtension();
            $request->file('foto')->move(public_path('image'), $foto);
            $data['foto'] = $foto;
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
