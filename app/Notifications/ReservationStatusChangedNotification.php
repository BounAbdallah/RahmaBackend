<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ReservationStatusChangedNotification extends Notification
{
    use Queueable;

    public $reservation;
    public $status;

    public function __construct($reservation, $status)
    {
        $this->reservation = $reservation;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // Envoyer par email et sauvegarder dans la base de données
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Mise à jour de votre réservation')
            ->view('emails.reservation-status-changed', [
                'reservation' => $this->reservation,
                'status' => $this->status,
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            'reservation_id' => $this->reservation->id,
            'status' => $this->status,
            'message' => "Le statut de votre réservation a été modifié à: {$this->status}.",
        ];
    }
}
