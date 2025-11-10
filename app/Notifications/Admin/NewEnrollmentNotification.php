<?php

namespace App\Notifications\Admin;

use App\Models\Enrollment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewEnrollmentNotification extends Notification
{
    use Queueable;

    public function __construct(
        private readonly Enrollment $enrollment
    ) {
        $this->enrollment->loadMissing(['user', 'training']);
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $user = $this->enrollment->user;
        $training = $this->enrollment->training;

        return [
            'category' => 'enrollment',
            'title' => 'New enrollment request',
            'message' => sprintf(
                '%s enrolled in %s (%s).',
                $user?->name ?? 'A user',
                $training?->title ?? 'a training',
                strtoupper($this->enrollment->currency)
            ),
            'action_url' => route('admin.enrollments.show', $this->enrollment->id),
            'meta' => [
                'enrollment_id' => $this->enrollment->id,
                'user_id' => $user?->id,
                'training_id' => $training?->id,
                'amount' => $this->enrollment->amount,
                'currency' => $this->enrollment->currency,
                'status' => $this->enrollment->status,
            ],
        ];
    }
}

