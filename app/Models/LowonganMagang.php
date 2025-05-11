<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LowonganMagang extends Model
{
    use HasFactory;


    protected $table = 'm_lowongan_magang';


    protected $fillable = [
        'perusahaan_id',
        'judul_lowongan',
        'deskripsi',
        'kuota',
        'sisa_kuota',
        'batas_pendaftaran',
        'status',
    ];

    /**
     * Relasi ke tabel m_perusahaan
     * Lowongan magang dimiliki oleh satu perusahaan
     */
    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'perusahaan_id');
    }
}