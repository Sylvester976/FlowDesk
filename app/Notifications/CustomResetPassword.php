<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPassword extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $resetUrl = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Civil Tracker Password Reset Request')
            ->greeting('Hello!')
            ->line('We received a request to reset your Civil Tracker account password.')
            ->action('Reset My Password', $resetUrl)
            ->line('This link will expire in 60 minutes.')
            ->line('If you did not request this password reset, please ignore this email.')
            ->salutation('Kind regards, The Civil Tracker Team');
    }
}
