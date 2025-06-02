<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeahlianMahasiswaModel extends Model
{
    use HasFactory;

    protected $table = 'm_keahlian_mahasiswa';
    protected $primaryKey = 'keahlian_mahasiswa_id';
    protected $fillable = ['mahasiswa_id', 'keahlian_id'];
    public $timestamps = true;
}
