<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BadgeReceived extends Notification
{
    use Queueable;

    public function __construct(
        public readonly string $name,
    ) {}

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Hello!')
            ->line(sprintf(
                    'You have received a badge \'%s\'.',
                    $this->name
                )
            )
            ->line('Thank you for using our application!');
    }
}
