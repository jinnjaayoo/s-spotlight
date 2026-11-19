<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_portofolio
 * @property string $nama_portofolio
 * @property string $nama_siswa
 * @property string $kategori
 * @property string|null $teknologi
 * @property string|null $link_portofolio
 * @property string $deskripsi
 * @property string|null $gambar
 * @property int|null $jumlah_love
 */

class Portofolio extends Model
{
    protected $table = 'portofolio';

    protected $primaryKey = 'id_portofolio';

    protected $fillable = [
        'nama_portofolio',
        'deskripsi',
        'kategori',
        'teknologi',
        'link_portofolio',
        'gambar',
        'nama_siswa',
    ];

    /**
     * Relasi ke pengajuan karya jika portofolio ini berasal dari pengajuan siswa.
     */
    public function pengajuan()
    {
        return $this->hasOne(PengumpulanKarya::class, 'id_portofolio', 'id_portofolio');
    }
}