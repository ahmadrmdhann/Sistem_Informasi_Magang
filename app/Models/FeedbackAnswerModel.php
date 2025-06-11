<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackAnswerModel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'm_feedback_answers';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'answer_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'response_id',
        'question_id',
        'answer_text',
        'rating_value',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'rating_value' => 'integer',
    ];

    /**
     * Get the feedback response that owns the answer.
     */
    public function response()
    {
        return $this->belongsTo(FeedbackResponseModel::class, 'response_id', 'response_id');
    }

    /**
     * Get the feedback question that owns the answer.
     */
    public function question()
    {
        return $this->belongsTo(FeedbackQuestionModel::class, 'question_id', 'question_id');
    }

    /**
     * Scope to get answers for rating questions.
     */
    public function scopeRatingAnswers($query)
    {
        return $query->whereHas('question', function ($q) {
            $q->where('question_type', 'rating');
        })->whereNotNull('rating_value');
    }

    /**
     * Scope to get answers for text questions.
     */
    public function scopeTextAnswers($query)
    {
        return $query->whereHas('question', function ($q) {
            $q->where('question_type', 'text');
        })->whereNotNull('answer_text');
    }

    /**
     * Scope to get answers for multiple choice questions.
     */
    public function scopeMultipleChoiceAnswers($query)
    {
        return $query->whereHas('question', function ($q) {
            $q->where('question_type', 'multiple_choice');
        })->whereNotNull('answer_text');
    }

    /**
     * Scope to get answers with specific rating value.
     */
    public function scopeWithRating($query, $rating)
    {
        return $query->where('rating_value', $rating);
    }

    /**
     * Scope to get answers for a specific question.
     */
    public function scopeForQuestion($query, $questionId)
    {
        return $query->where('question_id', $questionId);
    }

    /**
     * Get the display value for this answer.
     */
    public function getDisplayValueAttribute()
    {
        if ($this->question->isRatingQuestion()) {
            return $this->rating_value . '/10';
        }

        return $this->answer_text;
    }

    /**
     * Check if this answer has a value.
     */
    public function hasValue()
    {
        if ($this->question->isRatingQuestion()) {
            return !is_null($this->rating_value);
        }

        return !is_null($this->answer_text) && trim($this->answer_text) !== '';
    }

    /**
     * Get the formatted answer for display.
     */
    public function getFormattedAnswerAttribute()
    {
        if ($this->question->isRatingQuestion()) {
            return $this->rating_value ? $this->rating_value . ' dari 10' : 'Tidak dijawab';
        }

        if ($this->question->isTextQuestion()) {
            return $this->answer_text ?: 'Tidak dijawab';
        }

        if ($this->question->isMultipleChoiceQuestion()) {
            return $this->answer_text ?: 'Tidak dijawab';
        }

        return 'Tidak dijawab';
    }
}
