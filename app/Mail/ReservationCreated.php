<?php
// app/Mail/ReservationCreatedMail.php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;

    /**
     * Create a new message instance.
     *
     * @param  Reservation  $reservation
     * @return void
     */
    public function __construct(Reservation $reservation)
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
            subject: 'Nouvelle réservation effectuée',
        );
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Récupération des informations pour l'e-mail
        $annonce = $this->reservation->annonce->titre;
        $dateReservation = $this->reservation->date_reservation;
        $userName = $this->reservation->user->name;
        $annonceCreator = $this->reservation->annonce->user->name;

        // Construire le contenu HTML de l'e-mail
        return $this->subject('Nouvelle réservation sur votre annonce')
            ->html("
                <h1>Bonjour {$annonceCreator},</h1>
                <p>Une nouvelle réservation a été effectuée pour votre annonce : <strong>{$annonce}</strong>.</p>
                <p>Date de la réservation : <strong>{$dateReservation}</strong></p>
                <p>Réservé par : <strong>{$userName}</strong></p>
                <p>Merci d'utiliser notre plateforme !</p>
                <p>Cordialement,<br>L'équipe Rahma Delivery</p>
            ");
    }
}
