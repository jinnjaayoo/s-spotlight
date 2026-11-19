<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengumpulanKarya;
use App\Models\Portofolio;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PengajuanKaryaController extends Controller
{
    /**
     * Menampilkan daftar seluruh pengajuan karya siswa dengan pencarian dan filter.
     */
    public function index(Request $request)
    {
        $query = PengumpulanKarya::query();

        // Pencarian berdasarkan nama siswa, kelas, atau judul karya
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('nama_siswa', 'like', "%{$search}%")
                    ->orWhere('kelas', 'like', "%{$search}%")
                    ->orWhere('judul_karya', 'like', "%{$search}%");
            });
        }

        // Filter status peninjauan (pending, approved, rejected)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter kategori (Web, Apk, Desain, Gambar)
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter status publikasi (belum_dipublikasi, dipublikasikan)
        if ($request->filled('status_publikasi')) {
            $query->where('status_publikasi', $request->status_publikasi);
        }

        $pengajuans = $query->latest('id_pengumpulan')
            ->paginate(10)
            ->withQueryString();

        // Statistik ringkas untuk tab counter
        $counts = [
            'all' => PengumpulanKarya::count(),
            'pending' => PengumpulanKarya::where('status', 'pending')->count(),
            'approved' => PengumpulanKarya::where('status', 'approved')->count(),
            'rejected' => PengumpulanKarya::where('status', 'rejected')->count(),
            'dipublikasikan' => PengumpulanKarya::where('status_publikasi', 'dipublikasikan')->count(),
        ];

        return view('admin.pengajuan.index', compact('pengajuans', 'counts'));
    }

    /**
     * Menampilkan detail pengajuan karya siswa.
     */
    public function show($id)
    {
        $pengajuan = PengumpulanKarya::with('portofolio')->findOrFail($id);

        return view('admin.pengajuan.show', compact('pengajuan'));
    }

    /**
     * Memperbarui status peninjauan pengajuan karya (pending, approved, rejected).
     */
    public function updateStatus(Request $request, $id)
    {
        $pengajuan = PengumpulanKarya::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ], [
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
        ]);

        $statusBaru = $request->status;
        $updates = ['status' => $statusBaru];

        // Jika status diubah keluar dari approved padahal sudah terbit di portofolio,
        // tarik publikasi otomatis agar portofolio publik tetap konsisten.
        if ($statusBaru !== 'approved' && $pengajuan->status_publikasi === 'dipublikasikan') {
            if ($pengajuan->id_portofolio) {
                $porto = Portofolio::find($pengajuan->id_portofolio);
                if ($porto) {
                    if ($porto->gambar && file_exists(public_path('image/' . $porto->gambar))) {
                        unlink(public_path('image/' . $porto->gambar));
                    }
                    $porto->delete();
                }
            }
            $updates['status_publikasi'] = 'belum_dipublikasi';
            $updates['id_portofolio'] = null;
        }

        $pengajuan->update($updates);

        $statusLabels = [
            'pending' => 'Menunggu Peninjauan',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
        ];

        return redirect()
            ->route('admin.pengajuan.show', $id)
            ->with('success', "Status peninjauan berhasil diubah menjadi: {$statusLabels[$statusBaru]}.");
    }

    /**
     * Mempublikasikan karya yang telah disetujui (approved) ke tabel Portofolio.
     */
    public function publish(Request $request, $id)
    {
        $pengajuan = PengumpulanKarya::findOrFail($id);

        // Hanya karya berstatus approved yang boleh dipublikasikan
        if ($pengajuan->status !== 'approved') {
            return redirect()
                ->route('admin.pengajuan.show', $id)
                ->with('error', 'Hanya karya yang berstatus Disetujui (Approved) yang dapat dipublikasikan ke Portofolio.');
        }

        // Cegah duplikasi jika sudah terbit
        if ($pengajuan->status_publikasi === 'dipublikasikan' && $pengajuan->id_portofolio) {
            $existing = Portofolio::find($pengajuan->id_portofolio);
            if ($existing) {
                return redirect()
                    ->route('admin.pengajuan.show', $id)
                    ->with('error', 'Karya ini sudah dipublikasikan ke Portofolio sebelumnya.');
            }
        }

        $request->validate([
            'teknologi' => 'nullable|string|max:255',
            'link_portofolio' => 'nullable|url|max:255',
        ]);

        // Duplikasi file gambar ke salinan khusus portofolio (porto_xxx)
        // Hal ini menjamin file asli pengajuan siswa tidak akan terhapus jika portofolio diedit/dihapus
        $portoGambar = null;
        if ($pengajuan->gambar && file_exists(public_path('image/' . $pengajuan->gambar))) {
            $ext = pathinfo($pengajuan->gambar, PATHINFO_EXTENSION);
            $portoGambar = 'porto_' . Str::random(18) . ($ext ? '.' . $ext : '');
            copy(public_path('image/' . $pengajuan->gambar), public_path('image/' . $portoGambar));
        }

        // Buat data pada tabel portofolio
        $portofolio = Portofolio::create([
            'nama_portofolio' => $pengajuan->judul_karya,
            'nama_siswa' => $pengajuan->nama_siswa,
            'kategori' => $pengajuan->kategori,
            'teknologi' => $request->teknologi,
            'link_portofolio' => $request->link_portofolio,
            'deskripsi' => $pengajuan->deskripsi,
            'gambar' => $portoGambar,
        ]);

        // Catat status publikasi dan referensi id_portofolio pada pengajuan
        $pengajuan->update([
            'status_publikasi' => 'dipublikasikan',
            'id_portofolio' => $portofolio->id_portofolio,
        ]);

        return redirect()
            ->route('admin.pengajuan.show', $id)
            ->with('success', 'Selamat! Karya berhasil diterbitkan ke halaman Portofolio.');
    }

    /**
     * Menarik / membatalkan publikasi karya dari Portofolio publik.
     */
    public function unpublish($id)
    {
        $pengajuan = PengumpulanKarya::findOrFail($id);

        if ($pengajuan->id_portofolio) {
            $porto = Portofolio::find($pengajuan->id_portofolio);
            if ($porto) {
                if ($porto->gambar && file_exists(public_path('image/' . $porto->gambar))) {
                    unlink(public_path('image/' . $porto->gambar));
                }
                $porto->delete();
            }
        }

        $pengajuan->update([
            'status_publikasi' => 'belum_dipublikasi',
            'id_portofolio' => null,
        ]);

        return redirect()
            ->route('admin.pengajuan.show', $id)
            ->with('success', 'Publikasi karya berhasil ditarik dari Portofolio. Data pengajuan siswa tetap tersimpan.');
    }

    /**
     * Mengunduh berkas gambar karya asli yang diunggah siswa.
     */
    public function downloadGambar($id)
    {
        $pengajuan = PengumpulanKarya::findOrFail($id);
        $filePath = public_path('image/' . $pengajuan->gambar);

        if (!file_exists($filePath) || empty($pengajuan->gambar)) {
            return back()->with('error', 'Berkas gambar asli tidak ditemukan di server.');
        }

        $ext = pathinfo($filePath, PATHINFO_EXTENSION);
        $downloadName = Str::slug($pengajuan->judul_karya) . '-' . Str::slug($pengajuan->nama_siswa) . '.' . $ext;

        return response()->download($filePath, $downloadName);
    }

    /**
     * Menghapus data pengajuan (soft delete).
     */
    public function destroy($id)
    {
        $pengajuan = PengumpulanKarya::findOrFail($id);
        $pengajuan->delete();

        return redirect()
            ->route('admin.pengajuan.index')
            ->with('success', 'Data pengajuan berhasil dihapus.');
    }
}
