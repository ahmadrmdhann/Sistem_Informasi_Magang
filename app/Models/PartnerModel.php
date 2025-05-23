<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerModel extends Model
{
    protected $table = 'm_partner';
    protected $primaryKey = 'partner_id';
    public $timestamps = true;

    protected $fillable = [
        'nama',
        'kontak',
        'bidang_industri',
        'alamat',
    ];


    public function lowongans()
    {
        return $this->hasMany(LowonganModel::class, 'partner_id', 'partner_id');
    }
}