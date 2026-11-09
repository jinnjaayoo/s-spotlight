<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    protected $table = 'info_umum';

    protected $primaryKey = 'id_info';

    protected $fillable = [
        'judul',
        'isi',
        'gambar',
        'kategori',
        'tanggal',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];
}
