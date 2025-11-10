<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Notifications\Notification as NotificationContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Notification;

class AdminNotifier
{
    /**
     * Notify all admin users with the given notification.
     */
    public static function notify(NotificationContract $notification): void
    {
        $admins = self::admins();

        if ($admins->isEmpty()) {
            return;
        }

        Notification::send($admins, $notification);
    }

    /**
     * Get the current admin collection.
     *
     * @return \Illuminate\Support\Collection<int, \App\Models\User>
     */
    public static function admins(): Collection
    {
        return User::query()
            ->where('is_admin', true)
            ->get();
    }
}

