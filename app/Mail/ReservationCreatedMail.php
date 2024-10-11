<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;

    /**
     * Create a new message instance.
     *
     * @param  $reservation  Le modèle de la réservation
     * @return void
     */
    public function __construct($reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Get the envelope configuration.
     *
     * @return Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmation de réservation',
        );
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
{
    return $this->subject('Confirmation de réservation')
                ->view('emails.reservation-created')
                ->with([
                    'reservation' => $this->reservation,
                ]);
}
}
