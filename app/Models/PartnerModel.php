<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerModel extends Model
{
    protected $table = 'm_partner';
    protected $primaryKey = 'partner_id';

    protected $fillable = [
        'nama',
        'alamat',
        'telepon',
        'email',
    ];

    // Relasi ke lowongan
    public function lowongans()
    {
        return $this->hasMany(LowonganModel::class, 'partner_id', 'partner_id');
    }
}