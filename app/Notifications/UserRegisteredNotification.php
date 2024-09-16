<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class UserRegisteredNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;

    /**
     * Create a new notification instance.
     *
     * @param User $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Bienvenue sur notre application!')
            ->line('Bonjour ' . $this->user->prenom . ' ' . $this->user->nom . ',')
            ->line('Merci de vous être inscrit sur notre application.')
            ->line('Votre adresse e-mail est : ' . $this->user->email)
            ->line('Nous sommes ravis de vous accueillir!')
            ->action('Accéder à l\'application', url('/'))
            ->line('Si vous avez des questions, n\'hésitez pas à nous contacter.')
            ->line('Merci pour votre inscription!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array<string, mixed>
     */
    public function toArray($notifiable): array
    {
        return [
            'user' => $this->user,
        ];
    }
}
