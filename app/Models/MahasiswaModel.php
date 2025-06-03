<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaModel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'm_mahasiswa';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'mahasiswa_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'nim',
        'prodi_id',
        'keahlian_id',
        'minat_id',
        'lokasi_preferensi',
        'sertifikat',
        'cv_file',
    ];

    /**
     * Get the user that owns the mahasiswa profile.
     */
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }

    /**
     * Get the prodi that the mahasiswa belongs to.
     */
    public function prodi()
    {
        return $this->belongsTo(ProdiModel::class, 'prodi_id', 'prodi_id');
    }

    /**
     * Get the keahlian that the mahasiswa has.
     */
    public function keahlian()
    {
        return $this->belongsTo(KeahlianModel::class, 'keahlian_id', 'keahlian_id');
    }

    /**
     * Get the minat that the mahasiswa has.
     */
    public function minat()
    {
        return $this->belongsTo(KeahlianModel::class, 'minat_id', 'keahlian_id');
    }

    /**
     * Get the CV file URL.
     */
    public function PengajuanMagang()
    {
        return $this->hasMany(PengajuanMagangModel::class, 'mahasiswa_id', 'mahasiswa_id');
    }
    public function getCvUrlAttribute()
    {
        return $this->cv_file ? asset('storage/cv/' . $this->cv_file) : null;
    }
}
