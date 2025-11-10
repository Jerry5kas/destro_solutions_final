<?php

namespace App\Notifications\Admin;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PaymentStatusNotification extends Notification
{
    use Queueable;

    public function __construct(
        private readonly Payment $payment,
        private readonly string $statusLabel,
        private readonly ?string $note = null
    ) {
        $this->payment->loadMissing(['user', 'enrollment']);
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $user = $this->payment->user;
        $enrollment = $this->payment->enrollment;

        $message = sprintf(
            'Payment %s (%s) is now %s.',
            $this->payment->gateway_payment_id ?: '#'.$this->payment->id,
            $user?->name ?? 'unknown user',
            strtolower($this->statusLabel)
        );

        if ($this->note) {
            $message .= ' '.$this->note;
        }

        return [
            'category' => 'payment',
            'title' => 'Payment update',
            'message' => $message,
            'action_url' => route('admin.payments.show', $this->payment->id),
            'meta' => [
                'payment_id' => $this->payment->id,
                'enrollment_id' => $enrollment?->id,
                'user_id' => $user?->id,
                'amount' => $this->payment->amount,
                'currency' => $this->payment->currency,
                'status' => $this->statusLabel,
            ],
        ];
    }
}

