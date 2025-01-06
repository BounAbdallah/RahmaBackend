<?php
namespace App\Mail;

use App\Models\Colis;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ColisStatusUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $colis;
    public $statut;

    /**
     * Create a new message instance.
     *
     * @param  Colis  $colis
     * @param  string  $statut
     * @return void
     */
    public function __construct(Colis $colis, $statut)
    {
        $this->colis = $colis;
        $this->statut = $statut;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Mise à jour du statut de votre colis')
                    ->markdown('emails.status_updated')
                    ->with([
                        'colisTitre' => $this->colis->titre,
                        'statut' => $this->statut,
                        'colisId' => $this->colis->id,
                    ]);
    }
}
