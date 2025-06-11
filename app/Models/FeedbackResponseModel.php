<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackResponseModel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'm_feedback_responses';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'response_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'form_id',
        'mahasiswa_id',
        'pengajuan_id',
        'submitted_at',
        'is_test_mode',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'submitted_at' => 'datetime',
        'is_test_mode' => 'boolean',
    ];

    /**
     * Get the feedback form that owns the response.
     */
    public function form()
    {
        return $this->belongsTo(FeedbackFormModel::class, 'form_id', 'form_id');
    }

    /**
     * Get the mahasiswa that owns the response.
     */
    public function mahasiswa()
    {
        return $this->belongsTo(MahasiswaModel::class, 'mahasiswa_id', 'mahasiswa_id');
    }

    /**
     * Get the pengajuan magang related to this response.
     */
    public function pengajuan()
    {
        return $this->belongsTo(\App\Models\PengajuanMagangModel::class, 'pengajuan_id', 'id');
    }

    /**
     * Get the answers for the response.
     */
    public function answers()
    {
        return $this->hasMany(FeedbackAnswerModel::class, 'response_id', 'response_id');
    }

    /**
     * Scope to get responses for a specific form.
     */
    public function scopeForForm($query, $formId)
    {
        return $query->where('form_id', $formId);
    }

    /**
     * Scope to get responses by a specific mahasiswa.
     */
    public function scopeByMahasiswa($query, $mahasiswaId)
    {
        return $query->where('mahasiswa_id', $mahasiswaId);
    }

    /**
     * Scope to get responses within a date range.
     */
    public function scopeSubmittedBetween($query, $startDate, $endDate)
    {
        return $query->whereBetween('submitted_at', [$startDate, $endDate]);
    }

    /**
     * Get the average rating for this response.
     */
    public function getAverageRatingAttribute()
    {
        $ratingAnswers = $this->answers()
            ->whereHas('question', function ($query) {
                $query->where('question_type', 'rating');
            })
            ->whereNotNull('rating_value');

        if ($ratingAnswers->count() === 0) {
            return null;
        }

        $average = $ratingAnswers->avg('rating_value');
        return $average ? round($average, 2) : null;
    }

    /**
     * Get the total number of questions answered.
     */
    public function getTotalAnswersAttribute()
    {
        return $this->answers()->count();
    }

    /**
     * Get the completion percentage of this response.
     */
    public function getCompletionPercentageAttribute()
    {
        $totalQuestions = $this->form->questions()->count();
        $answeredQuestions = $this->answers()->count();

        if ($totalQuestions === 0) {
            return 100;
        }

        return round(($answeredQuestions / $totalQuestions) * 100, 2);
    }

    /**
     * Check if the response is complete (all required questions answered).
     */
    public function isComplete()
    {
        $requiredQuestions = $this->form->questions()->where('is_required', true)->pluck('question_id');
        $answeredRequiredQuestions = $this->answers()->whereIn('question_id', $requiredQuestions)->pluck('question_id');

        return $requiredQuestions->diff($answeredRequiredQuestions)->isEmpty();
    }

    /**
     * Get the company/partner name from the related pengajuan.
     */
    public function getCompanyNameAttribute()
    {
        return $this->pengajuan?->lowongan?->partner?->nama ?? 'N/A';
    }

    /**
     * Get the internship position title from the related pengajuan.
     */
    public function getPositionTitleAttribute()
    {
        return $this->pengajuan?->lowongan?->judul ?? 'N/A';
    }
}
