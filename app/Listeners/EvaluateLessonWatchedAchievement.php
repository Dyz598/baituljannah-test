<?php

namespace App\Listeners;

use App\Enum\AchievementType;
use App\Events\LessonWatched;
use App\Listeners\Middleware\DatabaseTransaction;
use App\Models\Achievement;
use App\Models\Badge;
use App\Notifications\AchievementUnlocked;
use App\Notifications\BadgeReceived;
use App\Service\BadgeEvaluator;
use App\Service\LessonWatchedEvaluator;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;

class EvaluateLessonWatchedAchievement implements ShouldQueue
{
    use InteractsWithQueue;

    public bool $afterCommit = true;
    public int $tries = 5;

    public function __construct(
        private readonly LessonWatchedEvaluator $evaluator,
        private readonly BadgeEvaluator         $badgeEvaluator,
    ) {}

    public function handle(LessonWatched $event): void
    {
        $user = $event->user;

        $unlockedAchievements = $this->evaluator->evaluate($user);

        if ($unlockedAchievements->count()) {
            $user->achievements()->attach($unlockedAchievements->pluck('id')->all());

            /** @var Achievement $unlockedAchievement */
            foreach ($unlockedAchievements as $unlockedAchievement) {
                $user->notify(new AchievementUnlocked(
                    AchievementType::LESSON_WATCHED,
                    $unlockedAchievement->level
                ));
            }
        }

        $unlockedBadges = $this->badgeEvaluator->evaluate($user);

        if ($unlockedBadges->count()) {
            $user->badges()->attach($unlockedBadges->pluck('id')->all());

            /** @var Badge $unlockedBadge */
            foreach ($unlockedBadges as $unlockedBadge) {
                $user->notify(new BadgeReceived(
                    $unlockedBadge->name
                ));
            }

            $user->currentBadge()->associate(
                $unlockedBadges->max('total_achievements')
            );

            $user->save();
        }
    }

    public function middleware(LessonWatched $event): array
    {
        $middlewares = [new DatabaseTransaction];

        if (!app()->environment('local')) {
            return [
                (new WithoutOverlapping($event->user->getKey()))
                    ->releaseAfter(5)
                    ->expireAfter(5 * 5),
                ...$middlewares
            ];
        }

        return $middlewares;
    }
}
