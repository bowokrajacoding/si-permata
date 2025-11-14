<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    use HasFactory;

    protected $table = 'surat_masuk';

    protected $fillable = [
        'nomor',
        'asal',
        'perihal',
        'tanggal',
        'lampiran',
        'keterangan',
    ];

    protected $appends = ['tipe'];

    public function getTipeAttribute()
    {
        return 'masuk';
    }
}
