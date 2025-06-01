<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanMagangModel extends Model
{
    protected $table = 'm_pengajuan_magang';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'mahasiswa_id',
        'lowongan_id',
        'status',
        'tanggal_pengajuan',
        'dokumen_pendukung',
    ];

    // Relasi ke mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(MahasiswaModel::class, 'mahasiswa_id', 'mahasiswa_id');
    }

    // Relasi ke lowongan
    public function lowongan()
    {
        return $this->belongsTo(LowonganModel::class, 'lowongan_id', 'lowongan_id');
    }
}