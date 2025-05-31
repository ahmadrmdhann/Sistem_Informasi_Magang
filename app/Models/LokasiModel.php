<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LokasiModel extends Model
{
    use HasFactory;

    protected $table = 'm_kota_kabupaten';
    protected $primaryKey = 'kabupaten_id';
    protected $fillable = [
        'nama',
        'provinsi_id',
    ];
    public function lowongan(){
        return $this->BelongsTo(LowonganModel::class, '');
    }
}
