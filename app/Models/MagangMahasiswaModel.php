<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MahasiswaModel;
use App\Models\LowonganModel;
use App\Models\PeriodeModel;

class MagangMahasiswaModel extends Model
{
    protected $table = 'm_pengajuan_magang';
    protected $primaryKey = 'pengajuan_id';
    public $timestamps = true;

    protected $fillable = [
        'mahasiswa_id',
        'lowongan_id',
        'periode_id',
        'status',
        'catatan',
    ];


    public function lowongan()
    {
        return $this->belongsTo(LowonganModel::class, 'lowongan_id', 'lowongan_id');
    }

    public function periode()
    {
        return $this->belongsTo(PeriodeModel::class, 'periode_id', 'periode_id');
    }
}