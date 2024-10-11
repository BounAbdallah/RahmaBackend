<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserRegisteredMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $roles;

    /**
     * Create a new message instance.
     *
     * @param  $user  Le modèle de l'utilisateur
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
        // Récupérer les rôles de l'utilisateur
        $this->roles = $user->getRoleNames()->implode(', ');
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
        return $this->subject('Confirmation d\'inscription sur Rahma Delivery')
                    ->view('emails.user-registered') // Utiliser la vue que nous avons créée
                    ->with([
                        'user' => $this->user,
                        'roles' => $this->roles,
                    ]);
    }
}
