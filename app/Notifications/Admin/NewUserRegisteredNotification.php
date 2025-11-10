<?php

namespace App\Notifications\Admin;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewUserRegisteredNotification extends Notification
{
    use Queueable;

    public function __construct(
        private readonly User $user
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'category' => 'user',
            'title' => 'New user registered',
            'message' => sprintf('%s (%s) just joined the platform.', $this->user->name, $this->user->email),
            'action_url' => route('admin.accounts'),
            'meta' => [
                'user_id' => $this->user->id,
                'email' => $this->user->email,
            ],
        ];
    }
}

