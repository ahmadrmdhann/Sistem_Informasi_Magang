<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LowonganModel extends Model
{
    protected $table = 'm_lowongan';
    protected $primaryKey = 'lowongan_id';

    protected $fillable = [
        'partner_id',
        'judul',
        'deskripsi',
        'persyaratan',
        'kabupaten_id',
        'keahlian_id',
        'periode_id',
        'tanggal_mulai',
        'tanggal_akhir',
    ];

    // Relasi ke Partner
    public function partner()
    {
        return $this->belongsTo(PartnerModel::class, 'partner_id', 'partner_id');
    }

    // Relasi ke Periode
    public function periode()
    {
        return $this->belongsTo(PeriodeModel::class, 'periode_id', 'periode_id');
    }
    public function lokasi(){
        return $this->belongsTo(LokasiModel::class, 'kabupaten_id', 'kabupaten_id' );
    }
    public function keahlian(){
        return $this->belongsTo(KeahlianModel::class, 'keahlian_id', 'keahlian_id');
    }
}
