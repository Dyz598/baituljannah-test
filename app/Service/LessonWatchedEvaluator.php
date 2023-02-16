<?php

declare(strict_types=1);

namespace App\Service;

use App\Enum\AchievementType;
use App\Models\Achievement;
use App\Models\User;
use App\Repository\AchievementRepository;
use Illuminate\Database\Eloquent\Collection;

/**
 * @author  Aldi Arief <aldiarief598@gmail.com>
 */
class LessonWatchedEvaluator
{
    public function __construct(
        protected readonly AchievementRepository $achievementRepository,
    ) {}

    public function evaluate(User $user): Collection
    {
        $unlockedAchievements = $this->achievementRepository
            ->findAchievedByTypeAndTotal(
                AchievementType::LESSON_WATCHED,
                $user->lessons_watched
            )->mapWithKeys(function (Achievement $item) {
                return [$item->getKey() => $item];
            })->all();

        $currentAchievements = $user->achievements()
            ->where('achievements.type', AchievementType::LESSON_WATCHED)
            ->get()
            ->mapWithKeys(function (Achievement $item) {
                return [$item->getKey() => $item];
            })->all();

        foreach ($currentAchievements as $key => $currentAchievement) {
            if (isset($unlockedAchievements[$key])) {
                unset($unlockedAchievements[$key]);
            }
        }

        return new Collection($unlockedAchievements);
    }
}
