<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackModel extends Model
{
    use HasFactory;

    protected $table = 'm_feedback';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'mahasiswa_id', // Stores users.id (student's user ID)
        'evaluator',
        'komentar', // Akan menyimpan ulasan kualitatif
        'tanggal',
        'skor_kesesuaian_tugas',
        'skor_kualitas_bimbingan',
        'skor_beban_kerja',
        'skor_suasana_kerja',
        'skor_pengembangan_hard_skills',
        'skor_pengembangan_soft_skills',
        'pelajaran_terbaik',
        'kritik_saran_perusahaan',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
        'skor_kesesuaian_tugas' => 'integer',
        'skor_kualitas_bimbingan' => 'integer',
        'skor_beban_kerja' => 'integer',
        'skor_suasana_kerja' => 'integer',
        'skor_pengembangan_hard_skills' => 'integer',
        'skor_pengembangan_soft_skills' => 'integer',
        'pelajaran_terbaik' => 'string',
        'kritik_saran_perusahaan' => 'string',
    ];

    /**
     * Get the user (student) who submitted the feedback.
     */
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'mahasiswa_id', 'id');
    }

    /**
     * Get the student (mahasiswa) that owns the feedback.
     */
    public function mahasiswa()
    {
        return $this->belongsTo(MahasiswaModel::class, 'mahasiswa_id');
    }

    // If you later add 'pengajuan_id' to m_feedback table:
    // public function pengajuanMagang()
    // {
    //     return $this->belongsTo(PengajuanMagangModel::class, 'pengajuan_id', 'id');
    // }
}
