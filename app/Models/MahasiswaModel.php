<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MahasiswaModel extends Model
{
    protected $table = 'm_mahasiswa'; 
    protected $primaryKey = 'mahasiswa_id'; 

    protected $fillable = [
        'user_id',
        'nama',
        'nim',
        'prodi_id',

    ];


    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }


    public function prodi()
    {
        return $this->belongsTo(ProdiModel::class, 'prodi_id', 'prodi_id');
    }
}
