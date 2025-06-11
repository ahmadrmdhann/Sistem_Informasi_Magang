<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ActivityAttachmentModel extends Model
{
    protected $table = 'm_activity_attachments';
    protected $primaryKey = 'attachment_id';
    public $timestamps = true;

    protected $fillable = [
        'activity_id',
        'original_filename',
        'stored_filename',
        'file_path',
        'file_type',
        'mime_type',
        'file_size',
        'description',
        'is_primary',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'file_size' => 'integer',
    ];

    /**
     * Get the activity that this attachment belongs to.
     */
    public function activity(): BelongsTo
    {
        return $this->belongsTo(ActivityLogModel::class, 'activity_id', 'activity_id');
    }

    /**
     * Get the full URL to the file.
     */
    public function getFileUrlAttribute()
    {
        return Storage::url($this->file_path);
    }

    /**
     * Get the formatted file size.
     */
    public function getFormattedFileSizeAttribute()
    {
        $bytes = $this->file_size;
        
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    /**
     * Get the file type icon.
     */
    public function getFileTypeIconAttribute()
    {
        return match($this->file_type) {
            'image' => 'fa-image',
            'document' => 'fa-file-alt',
            'pdf' => 'fa-file-pdf',
            'video' => 'fa-video',
            'audio' => 'fa-music',
            'archive' => 'fa-file-archive',
            default => 'fa-file',
        };
    }

    /**
     * Get the file type color.
     */
    public function getFileTypeColorAttribute()
    {
        return match($this->file_type) {
            'image' => 'text-green-600',
            'document' => 'text-blue-600',
            'pdf' => 'text-red-600',
            'video' => 'text-purple-600',
            'audio' => 'text-yellow-600',
            'archive' => 'text-gray-600',
            default => 'text-gray-500',
        };
    }

    /**
     * Check if the file is an image.
     */
    public function isImage()
    {
        return $this->file_type === 'image';
    }

    /**
     * Check if the file is a document.
     */
    public function isDocument()
    {
        return in_array($this->file_type, ['document', 'pdf']);
    }

    /**
     * Check if the file can be previewed.
     */
    public function canBePreviewed()
    {
        return in_array($this->file_type, ['image', 'pdf']);
    }

    /**
     * Scope for filtering by file type.
     */
    public function scopeByFileType($query, $fileType)
    {
        return $query->where('file_type', $fileType);
    }

    /**
     * Scope for primary attachments only.
     */
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    /**
     * Scope for images only.
     */
    public function scopeImages($query)
    {
        return $query->where('file_type', 'image');
    }

    /**
     * Scope for documents only.
     */
    public function scopeDocuments($query)
    {
        return $query->whereIn('file_type', ['document', 'pdf']);
    }

    /**
     * Delete the file from storage when the model is deleted.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($attachment) {
            if (Storage::exists($attachment->file_path)) {
                Storage::delete($attachment->file_path);
            }
        });
    }
}
