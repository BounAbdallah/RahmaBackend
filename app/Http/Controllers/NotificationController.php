<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // Récupérer toutes les notifications non lues de l'utilisateur connecté
    public function index()
    {
        // Récupérer toutes les notifications de l'utilisateur connecté
        $notifications = auth()->user()->notifications;

        return response()->json($notifications);
    }


    // Marquer une notification comme lue
    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
            return response()->json(['message' => 'Notification marquée comme lue']);
        }

        return response()->json(['error' => 'Notification non trouvée'], 404);
    }

    // Marquer toutes les notifications comme lues
    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return response()->json(['message' => 'Toutes les notifications ont été marquées comme lues']);
    }
}
