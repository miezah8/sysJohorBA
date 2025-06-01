<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class UserApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification’s delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Your Account is Activated')
                    ->greeting('Hello ' . $this->user->name . ',')
                    ->line('Your account has been verified by JHBA admin.')
                    ->line('You can log in using your registerd email and password.')
                    ->action('Login Now', url('/login'))
                    ->line('Forgot your password? just click “Forgot Password” in login page.');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'user_id'   => $this->user->id,
            'message'   => 'Your account are now active.',
        ];
    }
}
