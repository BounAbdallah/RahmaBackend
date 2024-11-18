<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StatutReservationChange extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public $statut;

    public function __construct(Reservation $reservation, $statut)
    {
        $this->reservation = $reservation;
        $this->statut = $statut;
    }

    public function build()
    {
        return $this->subject('Mise à jour du statut de votre réservation')
                    ->markdown('emails.statut_reservation_change');
    }
}
