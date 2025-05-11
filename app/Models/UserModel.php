<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserModel extends Authenticatable
{

    protected $table = 'm_user';
    protected $primaryKey = 'user_id';

    // Fillable Fields
    protected $fillable = [
        'username',
        'nama',
        'password',
        'level_id',
        'image', // Tambahan
    ];

    // Relationships
    public function level()
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }
    public function getRoleName()
    {
        return $this->level->level_nama;
    }

    public function hasRole($role)
    {
        return $this->level->level_kode === $role;
    }

    public function getRole()
    {
        return $this->level->level_kode;
    }
    
}