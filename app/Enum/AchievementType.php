<?php

declare(strict_types=1);

namespace App\Enum;

/**
 * @author  Aldi Arief <aldiarief598@gmail.com>
 */
enum AchievementType: string
{
    use EnumBehaviourTrait;

    case LESSON_WATCHED = 'lesson_watched';
    case COMMENT_WRITTEN = 'comment_written';

    public function getName(): string
    {
        return match ($this) {
            self::LESSON_WATCHED  => 'Lessons Watched',
            self::COMMENT_WRITTEN => 'Comments Written',
        };
    }
}
