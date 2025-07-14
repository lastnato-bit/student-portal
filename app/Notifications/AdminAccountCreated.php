<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminAccountCreated extends Notification
{
    use Queueable;

    public ?string $plainPassword;

    /**
     * Create a new notification instance.
     *
     * @param string|null $plainPassword
     */
    public function __construct(?string $plainPassword = null)
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * Get the notification delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $mailMessage = (new MailMessage)
            ->subject('Your Admin Account Has Been Created')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your admin account has been created successfully.')
            ->line('**Email:** ' . $notifiable->email);

        // If password was generated, include it
        if ($this->plainPassword) {
            $mailMessage->line('**Temporary Password:** ' . $this->plainPassword);
        } else {
            $mailMessage->line('You can use the password you specified when creating the account.');
        }

        $mailMessage
            ->action('Login to the Portal', url('/login'))
            ->line('Please change your password after logging in.')
            ->salutation('Regards, Laravel');

        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        return [];
    }
}
