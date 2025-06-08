<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenModel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'm_dosen';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'dosen_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'nidn',
        'bidang_minat',
    ];

    /**
     * Get the user that owns the dosen profile.
     */
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }

    public function bidang()
    {
        return $this->belongsTo(KeahlianModel::class, 'bidang_minat', 'keahlian_id');
    }
    /**
     * Get the full name of the dosen from the related user.
     */
    public function getNamaDosenAttribute()
    {
        return $this->user ? $this->user->nama : null;
    }
}
