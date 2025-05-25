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
        'bidang_keahlian',
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
     * Get the CV file URL.
     */
    public function getCvUrlAttribute()
    {
        return $this->cv_file ? asset('storage/cv/' . $this->cv_file) : null;
    }
}
