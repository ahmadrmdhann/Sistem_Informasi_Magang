<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackFormModel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'm_feedback_forms';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'form_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'is_active',
        'start_date',
        'end_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the questions for the feedback form.
     */
    public function questions()
    {
        return $this->hasMany(FeedbackQuestionModel::class, 'form_id', 'form_id')
                    ->orderBy('order_index');
    }

    /**
     * Get the responses for the feedback form.
     */
    public function responses()
    {
        return $this->hasMany(FeedbackResponseModel::class, 'form_id', 'form_id');
    }

    /**
     * Scope to get only active forms.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get forms available for the current date.
     */
    public function scopeAvailable($query)
    {
        $today = now()->toDateString();
        return $query->where('is_active', true)
                    ->where(function ($q) use ($today) {
                        $q->whereNull('start_date')
                          ->orWhere('start_date', '<=', $today);
                    })
                    ->where(function ($q) use ($today) {
                        $q->whereNull('end_date')
                          ->orWhere('end_date', '>=', $today);
                    });
    }

    /**
     * Check if the form is currently available.
     */
    public function isAvailable()
    {
        if (!$this->is_active) {
            return false;
        }

        $today = now()->toDateString();

        if ($this->start_date && $this->start_date > $today) {
            return false;
        }

        if ($this->end_date && $this->end_date < $today) {
            return false;
        }

        return true;
    }

    /**
     * Get the total number of responses for this form.
     */
    public function getTotalResponsesAttribute()
    {
        return $this->responses()->count();
    }

    /**
     * Get the average rating for rating questions in this form.
     */
    public function getAverageRatingAttribute()
    {
        $ratingQuestions = $this->questions()->where('question_type', 'rating')->pluck('question_id');
        
        if ($ratingQuestions->isEmpty()) {
            return null;
        }

        $averageRating = FeedbackAnswerModel::whereIn('question_id', $ratingQuestions)
            ->whereHas('response', function ($query) {
                $query->where('form_id', $this->form_id);
            })
            ->avg('rating_value');

        return $averageRating ? round($averageRating, 2) : null;
    }
}
