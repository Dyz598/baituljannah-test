<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Enum\AchievementType;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AchievementUnlocked extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly AchievementType $achievementType,
        public readonly int             $level,
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
                    'You have unlocked an achievement \'%s - Level %s\'.',
                    $this->achievementType->getName(), $this->level
                )
            )
            ->line('Thank you for using our application!');
    }
}
