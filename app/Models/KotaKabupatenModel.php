<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KotaKabupatenModel extends Model
{
    use HasFactory;

    protected $table = 'm_kota_kabupaten';
    protected $primaryKey = 'kabupaten_id';
    public $timestamps = true;

    protected $fillable = [
        'provinsi_id',
        'nama',
        'lat',
        'lng'
    ];
}
