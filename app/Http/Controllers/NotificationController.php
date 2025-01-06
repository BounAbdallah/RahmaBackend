<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // Récupérer toutes les notifications de l'utilisateur connecté
    public function index()
    {
        // Récupérer les notifications non lues
        $notifications = auth()->user()->notifications()->get();

        // Ajouter le champ 'data' pour accéder au message de la notification
        $formattedNotifications = $notifications->map(function ($notification) {
            return [
                'id' => $notification->id,
                'message' => $notification->data['message'], // Extraire le message de la notification
                'read_at' => $notification->read_at,
                'created_at' => $notification->created_at,
            ];
        });

        return response()->json($formattedNotifications);
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
