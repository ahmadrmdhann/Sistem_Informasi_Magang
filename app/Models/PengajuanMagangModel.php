<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanMagangModel extends Model
{
    protected $table = 'm_pengajuan_magang';
    protected $primaryKey = 'pengajuan_id';
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
        return $this->belongsTo(UserModel::class, 'mahasiswa_id', 'user_id');
    }

    // Relasi ke lowongan
    public function lowongan()
    {
        return $this->belongsTo(LowonganModel::class, 'lowongan_id', 'lowongan_id');
    }
}