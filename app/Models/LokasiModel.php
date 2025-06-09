<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LokasiModel extends Model
{
    use HasFactory;

    protected $table = 'm_kota_kabupaten';
    protected $primaryKey = 'kabupaten_id';
    protected $fillable = [
        'nama',
        'provinsi_id',
        'lat',
        'lng'
    ];

    protected $casts = [
        'lat' => 'double',
        'lng' => 'double'
    ];

    public function lowongan()
    {
        return $this->hasMany(LowonganModel::class, 'kabupaten_id', 'kabupaten_id');
    }

    public function mahasiswa()
    {
        return $this->hasMany(MahasiswaModel::class, 'lokasi_preferensi', 'kabupaten_id');
    }
}
