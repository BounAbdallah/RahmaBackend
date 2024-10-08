<?php
// app/Mail/UserRegisteredMail.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserRegisteredMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     *
     * @param  $user  Le modèle de l'utilisateur
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the envelope configuration.
     *
     * @return Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmation d\'inscription',
        );
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Utiliser Spatie pour récupérer le(s) rôle(s) de l'utilisateur
        $roleNames = $this->user->getRoleNames(); // Renvoie une collection de rôles
        $roleList = $roleNames->implode(', '); // Convertit les rôles en une chaîne, séparée par des virgules

        return $this->subject('Confirmation d\'inscription sur Rahma Delivery')
                    ->html("<h1>Bonjour {$this->user->prenom} {$this->user->nom},</h1>
                    <h2>Vous avez le rôle de : <strong>{$roleList}</strong></h2>
                    <p>Merci de vous être inscrit sur notre plateforme. Nous sommes ravis de vous accueillir!</p>
                    <p>Votre adresse e-mail est : <strong>{$this->user->email}</strong></p>
                    <p>Nous vous tiendrons informé des prochaines étapes et de nos nouvelles fonctionnalités.</p>
                    <p>Si vous avez des questions, n'hésitez pas à nous contacter.</p>
                    <p>Cordialement,<br>Équipe Rahma Delivery</p>");
    }
}
