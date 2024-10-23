<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ReservationNotification extends Notification
{
    use Queueable;

    public $reservation;
    public $message;

    public function __construct($reservation, $message)
    {
        $this->reservation = $reservation;
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['database']; // Utilise la base de données pour stocker la notification
    }

    public function toArray($notifiable)
    {
        return [
            'reservation_id' => $this->reservation->id,
            'message' => $this->message,
            'user_id' => $this->reservation->user_id,
        ];
    }
}
