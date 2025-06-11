<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ActivityLogModel extends Model
{
    protected $table = 'm_activity_logs';
    protected $primaryKey = 'activity_id';
    public $timestamps = true;

    protected $fillable = [
        'mahasiswa_id',
        'pengajuan_id',
        'dosen_id',
        'activity_date',
        'start_time',
        'end_time',
        'activity_title',
        'activity_description',
        'learning_objectives',
        'challenges_faced',
        'solutions_applied',
        'status',
        'submitted_at',
        'reviewed_at',
        'is_weekly_summary',
        'week_start_date',
        'week_end_date',
    ];

    protected $casts = [
        'activity_date' => 'date',
        'week_start_date' => 'date',
        'week_end_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'is_weekly_summary' => 'boolean',
    ];

    /**
     * Get the mahasiswa that owns the activity log.
     */
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(MahasiswaModel::class, 'mahasiswa_id', 'mahasiswa_id');
    }

    /**
     * Get the pengajuan magang associated with this activity.
     */
    public function pengajuan(): BelongsTo
    {
        return $this->belongsTo(PengajuanMagangModel::class, 'pengajuan_id', 'id');
    }

    /**
     * Get the dosen supervisor for this activity.
     */
    public function dosen(): BelongsTo
    {
        return $this->belongsTo(DosenModel::class, 'dosen_id', 'dosen_id');
    }

    /**
     * Get all reviews for this activity.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(ActivityReviewModel::class, 'activity_id', 'activity_id');
    }

    /**
     * Get the latest review for this activity.
     */
    public function latestReview(): HasOne
    {
        return $this->hasOne(ActivityReviewModel::class, 'activity_log_id', 'activity_log_id')->latestOfMany();
    }

    /**
     * Get all attachments for this activity.
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(ActivityAttachmentModel::class, 'activity_id', 'activity_id');
    }

    /**
     * Get the primary attachment for this activity.
     */
    public function primaryAttachment(): HasOne
    {
        return $this->hasOne(ActivityAttachmentModel::class, 'activity_id', 'activity_id')
                    ->where('is_primary', true);
    }

    /**
     * Scope for filtering by status.
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for filtering by mahasiswa.
     */
    public function scopeByMahasiswa($query, $mahasiswaId)
    {
        return $query->where('mahasiswa_id', $mahasiswaId);
    }

    /**
     * Scope for filtering by dosen.
     */
    public function scopeByDosen($query, $dosenId)
    {
        return $query->where('dosen_id', $dosenId);
    }

    /**
     * Scope for filtering by date range.
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('activity_date', [$startDate, $endDate]);
    }

    /**
     * Scope for pending activities.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for approved activities.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Get the status badge color.
     */
    public function getStatusBadgeColorAttribute()
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'approved' => 'bg-green-100 text-green-800',
            'needs_revision' => 'bg-orange-100 text-orange-800',
            'rejected' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get the status icon.
     */
    public function getStatusIconAttribute()
    {
        return match($this->status) {
            'pending' => 'fa-clock',
            'approved' => 'fa-check-circle',
            'needs_revision' => 'fa-edit',
            'rejected' => 'fa-times-circle',
            default => 'fa-question-circle',
        };
    }

    /**
     * Get the formatted activity duration.
     */
    public function getDurationAttribute()
    {
        if (!$this->start_time || !$this->end_time) {
            return null;
        }

        $start = \Carbon\Carbon::parse($this->start_time);
        $end = \Carbon\Carbon::parse($this->end_time);
        
        return $start->diffInHours($end) . ' jam ' . ($start->diffInMinutes($end) % 60) . ' menit';
    }

    /**
     * Check if activity can be edited.
     */
    public function canBeEdited()
    {
        return in_array($this->status, ['pending', 'needs_revision']);
    }

    /**
     * Check if activity has been reviewed.
     */
    public function hasBeenReviewed()
    {
        return !is_null($this->reviewed_at);
    }

    /**
     * Mark activity as submitted.
     */
    public function markAsSubmitted()
    {
        $this->update([
            'status' => 'pending',
            'submitted_at' => now(),
        ]);
    }

    /**
     * Mark activity as reviewed.
     */
    public function markAsReviewed($status, $dosenId)
    {
        $this->update([
            'status' => $status,
            'reviewed_at' => now(),
            'dosen_id' => $dosenId,
        ]);
    }
}
