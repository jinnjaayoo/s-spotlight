<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id_pengumpulan
 * @property string $nama_siswa
 * @property string $kelas
 * @property string $judul_karya
 * @property string $kategori
 * @property string $deskripsi
 * @property string $gambar
 * @property string $status  Status peninjauan: pending, approved, rejected
 * @property string $status_publikasi  Status publikasi: belum_dipublikasi, dipublikasikan
 * @property int|null $id_portofolio  ID referensi portofolio jika sudah diterbitkan
 * @property \Illuminate\Support\Carbon $created_at  Tanggal pengajuan
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Portofolio|null $portofolio
 */
class PengumpulanKarya extends Model
{
    // Data pengajuan tidak dihapus permanen agar tetap tersedia untuk laporan.
    use SoftDeletes;

    protected $table = 'pengumpulan_karya';

    protected $primaryKey = 'id_pengumpulan';

    protected $fillable = [
        'nama_siswa',
        'kelas',
        'judul_karya',
        'kategori',
        'deskripsi',
        'gambar',
        'status',
        'status_publikasi',
        'id_portofolio',
    ];

    /**
     * Relasi ke Portofolio saat pengajuan ini diterbitkan.
     */
    public function portofolio()
    {
        return $this->belongsTo(Portofolio::class, 'id_portofolio', 'id_portofolio');
    }
}
