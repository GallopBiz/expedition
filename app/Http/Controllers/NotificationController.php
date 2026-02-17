<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function markAllRead(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $user->notifications()->where('read', false)->update(['read' => true]);
        }
        return response()->json(['success' => true]);
    }

    public function markRead($id)
    {
        $user = Auth::user();
        if ($user) {
            $notification = $user->notifications()->where('id', $id)->first();
            if ($notification) {
                $notification->read = true;
                $notification->save();
            }
        }
        return response()->json(['success' => true]);
    }
}
