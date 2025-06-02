<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeahlianModel extends Model
{
    use HasFactory;

    protected $table = 'm_keahlian';
    protected $primaryKey = 'keahlian_id';
    protected $fillable = ['nama'];
    public $timestamps = true;

    /**
     * Get the mahasiswa that has this keahlian.
     */
    public function mahasiswa()
    {
        return $this->belongsToMany(MahasiswaModel::class, 'm_keahlian_mahasiswa', 'keahlian_id', 'mahasiswa_id')
                    ->withTimestamps();
    }
    /**
     * Get the lowongan that requires this keahlian.
     */
    public function lowongan()
    {
        return $this->belongsToMany(LowonganModel::class, 'm_keahlian_lowongan', 'keahlian_id', 'lowongan_id')
                    ->withTimestamps();
    }
}
