<?php


namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserReservationStatusChangedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public $status;

    public function __construct(Reservation $reservation, $status)
    {
        $this->reservation = $reservation;
        $this->status = $status;
    }

    public function build()
    {
        return $this
            ->subject('Mise à jour du statut de votre réservation')
            ->view('emails.user_reservation_status_changed')
            ->with([
                'reservation' => $this->reservation,
                'status' => $this->status,
            ]);
    }
}
