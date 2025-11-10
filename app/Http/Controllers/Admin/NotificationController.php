<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $admin = $request->user();

        $notifications = $admin->notifications()
            ->latest()
            ->limit(25)
            ->get();

        return response()->json([
            'notifications' => $notifications->map(fn ($notification) => [
                'id' => $notification->id,
                'data' => $notification->data,
                'read_at' => optional($notification->read_at)?->toIso8601String(),
                'created_at' => $notification->created_at->toIso8601String(),
                'time_ago' => $notification->created_at->diffForHumans(),
            ]),
            'unread_count' => $admin->unreadNotifications()->count(),
        ]);
    }

    public function markAsRead(Request $request, string $notificationId)
    {
        $notification = $request->user()
            ->notifications()
            ->where('id', $notificationId)
            ->firstOrFail();

        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        return response()->json([
            'success' => true,
            'notification_id' => $notification->id,
        ]);
    }

    public function markAllAsRead(Request $request)
    {
        $request->user()->unreadNotifications()
            ->update(['read_at' => now()]);

        return response()->json([
            'success' => true,
        ]);
    }
}

