<?php

namespace App\Services;

use App\Models\NotificationModel;
use App\Models\UserModel;

class NotificationService
{
    /**
     * Create a notification for a specific user.
     */
    public static function create($userId, $title, $message, $type = 'info', $data = null)
    {
        return NotificationModel::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'data' => $data,
        ]);
    }

    /**
     * Create notifications for multiple users.
     */
    public static function createForUsers($userIds, $title, $message, $type = 'info', $data = null)
    {
        $notifications = [];
        
        foreach ($userIds as $userId) {
            $notifications[] = [
                'user_id' => $userId,
                'title' => $title,
                'message' => $message,
                'type' => $type,
                'data' => $data,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        NotificationModel::insert($notifications);
    }

    /**
     * Notify when pengajuan magang status changes.
     */
    public static function notifyPengajuanStatusChange($pengajuan, $oldStatus, $newStatus)
    {
        $mahasiswaUserId = $pengajuan->mahasiswa->user_id;
        
        $statusMessages = [
            'diterima' => 'Selamat! Pengajuan magang Anda telah diterima.',
            'ditolak' => 'Pengajuan magang Anda ditolak. Silakan coba lagi dengan lowongan lain.',
        ];

        $statusTypes = [
            'diterima' => 'success',
            'ditolak' => 'error',
        ];

        if (isset($statusMessages[$newStatus])) {
            self::create(
                $mahasiswaUserId,
                'Status Pengajuan Magang',
                $statusMessages[$newStatus],
                $statusTypes[$newStatus],
                [
                    'pengajuan_id' => $pengajuan->id,
                    'lowongan_title' => $pengajuan->lowongan->judul,
                    'company' => $pengajuan->lowongan->partner->nama,
                ]
            );
        }
    }

    /**
     * Notify when activity review is completed.
     */
    public static function notifyActivityReviewed($activity, $review)
    {
        $mahasiswaUserId = $activity->mahasiswa->user_id;
        
        $statusMessages = [
            'approved' => 'Kegiatan magang Anda telah disetujui oleh dosen pembimbing.',
            'needs_revision' => 'Kegiatan magang Anda perlu revisi. Silakan periksa feedback dari dosen.',
            'rejected' => 'Kegiatan magang Anda ditolak. Silakan periksa feedback dari dosen.',
        ];

        $statusTypes = [
            'approved' => 'success',
            'needs_revision' => 'warning',
            'rejected' => 'error',
        ];

        if (isset($statusMessages[$review->review_status])) {
            self::create(
                $mahasiswaUserId,
                'Review Kegiatan Magang',
                $statusMessages[$review->review_status],
                $statusTypes[$review->review_status],
                [
                    'activity_id' => $activity->activity_id,
                    'review_id' => $review->review_id,
                    'activity_title' => $activity->activity_title,
                ]
            );
        }
    }

    /**
     * Notify dosen when new activity is submitted for review.
     */
    public static function notifyNewActivityForReview($activity)
    {
        if ($activity->dosen_id) {
            $dosenUserId = $activity->dosen->user_id;
            
            self::create(
                $dosenUserId,
                'Kegiatan Baru untuk Review',
                "Mahasiswa {$activity->mahasiswa->user->nama} telah mengirimkan kegiatan baru untuk direview.",
                'info',
                [
                    'activity_id' => $activity->activity_id,
                    'mahasiswa_id' => $activity->mahasiswa_id,
                    'activity_title' => $activity->activity_title,
                ]
            );
        }
    }

    /**
     * Notify when feedback form is available.
     */
    public static function notifyFeedbackFormAvailable($formId, $userIds)
    {
        self::createForUsers(
            $userIds,
            'Form Feedback Baru',
            'Form feedback baru telah tersedia. Silakan isi feedback Anda.',
            'info',
            [
                'form_id' => $formId,
                'action' => 'feedback_form',
            ]
        );
    }

    /**
     * Notify admin when new pengajuan is submitted.
     */
    public static function notifyAdminNewPengajuan($pengajuan)
    {
        // Get all admin users
        $adminUsers = UserModel::whereHas('level', function($query) {
            $query->where('level_kode', 'ADM');
        })->pluck('user_id');

        foreach ($adminUsers as $adminUserId) {
            self::create(
                $adminUserId,
                'Pengajuan Magang Baru',
                "Pengajuan magang baru dari {$pengajuan->mahasiswa->user->nama} untuk posisi {$pengajuan->lowongan->judul}.",
                'info',
                [
                    'pengajuan_id' => $pengajuan->id,
                    'mahasiswa_name' => $pengajuan->mahasiswa->user->nama,
                    'lowongan_title' => $pengajuan->lowongan->judul,
                ]
            );
        }
    }

    /**
     * Create welcome notification for new users.
     */
    public static function createWelcomeNotification($userId, $userLevel)
    {
        $welcomeMessages = [
            'MHS' => 'Selamat datang di SISFORMA! Mulai eksplorasi lowongan magang dan kembangkan karir Anda.',
            'DSN' => 'Selamat datang di SISFORMA! Anda dapat membimbing mahasiswa dan mereview kegiatan magang mereka.',
            'ADM' => 'Selamat datang di SISFORMA! Kelola sistem magang dengan kontrol penuh.',
        ];

        $message = $welcomeMessages[$userLevel] ?? 'Selamat datang di SISFORMA!';

        self::create(
            $userId,
            'Selamat Datang!',
            $message,
            'success'
        );
    }
}
