<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodeModel extends Model
{
    protected $table = 'm_periode';
    protected $primaryKey = 'periode_id';

    protected $fillable = [
        'nama_periode',
        'tanggal_mulai',
        'tanggal_akhir',
    ];

    // Relasi ke lowongan
    public function lowongans()
    {
        return $this->hasMany(LowonganModel::class, 'periode_id', 'periode_id');
    }
}