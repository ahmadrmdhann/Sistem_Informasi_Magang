<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodeModel extends Model
{
    protected $table = 'm_periode';
    protected $primaryKey = 'periode_id';

    protected $fillable = [
        'nama',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    // Relasi ke lowongan
    public function lowongans()
    {
        return $this->hasMany(LowonganModel::class, 'periode_id', 'periode_id');
    }
}