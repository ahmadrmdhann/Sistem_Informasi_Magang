<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityReviewModel extends Model
{
    protected $table = 'm_activity_reviews';
    protected $primaryKey = 'review_id';
    public $timestamps = true;

    protected $fillable = [
        'activity_id',
        'dosen_id',
        'review_status',
        'feedback_comment',
        'rating',
        'suggestions',
        'reviewed_at',
        'is_final_review',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
        'is_final_review' => 'boolean',
        'rating' => 'integer',
    ];

    /**
     * Get the activity that this review belongs to.
     */
    public function activity(): BelongsTo
    {
        return $this->belongsTo(ActivityLogModel::class, 'activity_id', 'activity_id');
    }

    /**
     * Get the dosen who made this review.
     */
    public function dosen(): BelongsTo
    {
        return $this->belongsTo(DosenModel::class, 'dosen_id', 'dosen_id');
    }

    /**
     * Get the status badge color for review status.
     */
    public function getReviewStatusBadgeColorAttribute()
    {
        return match($this->review_status) {
            'approved' => 'bg-green-100 text-green-800',
            'needs_revision' => 'bg-orange-100 text-orange-800',
            'rejected' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get the status icon for review status.
     */
    public function getReviewStatusIconAttribute()
    {
        return match($this->review_status) {
            'approved' => 'fa-check-circle',
            'needs_revision' => 'fa-edit',
            'rejected' => 'fa-times-circle',
            default => 'fa-question-circle',
        };
    }

    /**
     * Get the rating stars display.
     */
    public function getRatingStarsAttribute()
    {
        if (!$this->rating) {
            return 'Tidak ada rating';
        }

        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $this->rating) {
                $stars .= '<i class="fas fa-star text-yellow-400"></i>';
            } else {
                $stars .= '<i class="far fa-star text-gray-300"></i>';
            }
        }
        
        return $stars . ' (' . $this->rating . '/5)';
    }

    /**
     * Scope for filtering by review status.
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('review_status', $status);
    }

    /**
     * Scope for filtering by dosen.
     */
    public function scopeByDosen($query, $dosenId)
    {
        return $query->where('dosen_id', $dosenId);
    }

    /**
     * Scope for final reviews only.
     */
    public function scopeFinalReviews($query)
    {
        return $query->where('is_final_review', true);
    }
}
