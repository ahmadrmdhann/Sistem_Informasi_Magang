<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    use HasFactory;

    protected $table = 'm_perusahaan';


    protected $fillable = [
        'nama_perusahaan',
        'email',
        'telepon',
        'alamat',
        'website',
        'logo',
    ];


    public function lowonganMagang()
    {
        return $this->hasMany(LowonganMagang::class, 'perusahaan_id');
    }
}