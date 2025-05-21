<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdiModel extends Model
{
    use HasFactory;

    protected $table = 'm_prodi';
    protected $primaryKey = 'prodi_id';
    protected $fillable = [
        'prodi_nama',
        'prodi_kode',
    ];
     public $timestamps = true;
}