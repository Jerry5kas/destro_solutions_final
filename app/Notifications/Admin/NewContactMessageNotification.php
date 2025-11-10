<?php

namespace App\Notifications\Admin;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewContactMessageNotification extends Notification
{
    use Queueable;

    public function __construct(
        private readonly Contact $contact
    ) {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'category' => 'contact',
            'title' => 'New contact message',
            'message' => sprintf('%s just sent a new message.', $this->contact->name),
            'action_url' => route('admin.contacts.show', $this->contact->id),
            'meta' => [
                'email' => $this->contact->email,
                'mobile' => $this->contact->mobile,
            ],
        ];
    }
}

