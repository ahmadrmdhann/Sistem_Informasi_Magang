<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackQuestionModel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'm_feedback_questions';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'question_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'form_id',
        'question_text',
        'question_type',
        'options',
        'is_required',
        'order_index',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'options' => 'array',
        'is_required' => 'boolean',
        'order_index' => 'integer',
    ];

    /**
     * Get the feedback form that owns the question.
     */
    public function form()
    {
        return $this->belongsTo(FeedbackFormModel::class, 'form_id', 'form_id');
    }

    /**
     * Get the answers for the question.
     */
    public function answers()
    {
        return $this->hasMany(FeedbackAnswerModel::class, 'question_id', 'question_id');
    }

    /**
     * Scope to get questions ordered by their index.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order_index');
    }

    /**
     * Scope to get only required questions.
     */
    public function scopeRequired($query)
    {
        return $query->where('is_required', true);
    }

    /**
     * Scope to get questions by type.
     */
    public function scopeByType($query, $type)
    {
        return $query->where('question_type', $type);
    }

    /**
     * Check if this is a rating question.
     */
    public function isRatingQuestion()
    {
        return $this->question_type === 'rating';
    }

    /**
     * Check if this is a text question.
     */
    public function isTextQuestion()
    {
        return $this->question_type === 'text';
    }

    /**
     * Check if this is a multiple choice question.
     */
    public function isMultipleChoiceQuestion()
    {
        return $this->question_type === 'multiple_choice';
    }

    /**
     * Get the average rating for this question.
     */
    public function getAverageRatingAttribute()
    {
        if (!$this->isRatingQuestion()) {
            return null;
        }

        $average = $this->answers()->avg('rating_value');
        return $average ? round($average, 2) : null;
    }

    /**
     * Get the total number of answers for this question.
     */
    public function getTotalAnswersAttribute()
    {
        return $this->answers()->count();
    }

    /**
     * Get the distribution of ratings for this question (for rating questions).
     */
    public function getRatingDistributionAttribute()
    {
        if (!$this->isRatingQuestion()) {
            return null;
        }

        $distribution = [];
        for ($i = 1; $i <= 10; $i++) {
            $distribution[$i] = $this->answers()->where('rating_value', $i)->count();
        }

        return $distribution;
    }

    /**
     * Get the most common answers for multiple choice questions.
     */
    public function getChoiceDistributionAttribute()
    {
        if (!$this->isMultipleChoiceQuestion()) {
            return null;
        }

        return $this->answers()
            ->selectRaw('answer_text, COUNT(*) as count')
            ->groupBy('answer_text')
            ->orderByDesc('count')
            ->get()
            ->pluck('count', 'answer_text')
            ->toArray();
    }
}
