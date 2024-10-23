<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationStatusChangedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public $status;

    /**
     * Create a new message instance.
     *
     * @param  $reservation  Le modèle de la réservation
     * @param  $status  Le nouveau statut de la réservation
     * @return void
     */
    public function __construct($reservation, $status)
    {
        $this->reservation = $reservation;
        $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Mise à jour du statut de votre réservation')
                    ->view('emails.reservation-status-changed')
                    ->with([
                        'reservation' => $this->reservation,
                        'status' => $this->status,
                    ]);
    }
}
