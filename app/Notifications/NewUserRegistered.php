<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue; // (jika mahu queue)
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class NewUserRegistered extends Notification implements ShouldQueue
{
    use Queueable;

    protected $newUser;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $newUser)
    {
        $this->newUser = $newUser;
    }

    /**
     * Get the notification’s delivery channels.
     */
    public function via(object $notifiable): array
    {
        // Hantar melalui emel
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // $notifiable adalah instance User (admin)
        return (new MailMessage)
                    ->subject('New User Registration for Verification')
                    ->greeting('Hi Admin,')
                    ->line('A new user have register!.')
                    ->line('User Information: ')
                    ->line('— Name: ' . $this->newUser->name)
                    ->line('— IC Number: ' . $this->newUser->ic_number)
                    ->line('— E-mail: ' . $this->newUser->email)
                    ->line('— Tel. No.: ' . $this->newUser->contact_no)
                    ->action('Check & Verify Registration', url('/admin/users'))
                    ->line('Please log in and verify for user account activation.');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'new_user_id'   => $this->newUser->id,
            'new_user_name' => $this->newUser->name,
        ];
    }
}
