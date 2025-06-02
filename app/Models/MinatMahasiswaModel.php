<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MinatMahasiswaModel extends Model
{
    use HasFactory;

    protected $table = 'm_minat_mahasiswa';
    protected $primaryKey = 'minat_mahasiswa_id';
    protected $fillable = ['mahasiswa_id', 'keahlian_id'];
    public $timestamps = true;
}
