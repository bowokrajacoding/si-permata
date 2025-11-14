<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    protected $table = 'surat_keluar'; // TABEL YANG BENAR

    protected $fillable = [
        'nomor',
        'tujuan',
        'perihal',
        'tanggal',
        'isi',
        'file_pdf',
    ];
}
