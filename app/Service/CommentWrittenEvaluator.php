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
class CommentWrittenEvaluator
{
    public function __construct(
        protected readonly AchievementRepository $achievementRepository,
    ) {}

    public function evaluate(User $user): Collection
    {
        $unlockedAchievements = $this->achievementRepository
            ->findAchievedByTypeAndTotal(
                AchievementType::COMMENT_WRITTEN,
                $user->comments_written
            )->mapWithKeys(function (Achievement $item) {
                return [$item->getKey() => $item];
            })->all();

        $currentAchievements = $user->achievements()
            ->where('achievements.type', AchievementType::COMMENT_WRITTEN)
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
