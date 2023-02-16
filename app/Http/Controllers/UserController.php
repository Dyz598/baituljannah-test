<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Events\CommentWritten;
use App\Events\LessonWatched;
use App\Models\User;
use App\Repository\AchievementRepository;
use App\Repository\BadgeRepository;
use App\Repository\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    public function __construct(
        protected readonly UserRepository        $userRepository,
        protected readonly BadgeRepository       $badgeRepository,
        protected readonly AchievementRepository $achievementRepository,
    ) {}

    public function watch(User $user): JsonResponse
    {
        $this->userRepository->lockForUpdateById($user->getKey());

        $user->lessons_watched += 1;
        $user->save();

        event(new LessonWatched($user));

        return response()->json(['message' => 'success']);
    }

    public function comment(User $user): JsonResponse
    {
        $this->userRepository->lockForUpdateById($user->getKey());

        $user->comments_written += 1;
        $user->save();

        event(new CommentWritten($user));

        return response()->json(['message' => 'success']);
    }

    public function achievements(User $user): JsonResponse
    {
        $cacheTag = sprintf('user_%s', $user->getKey());
        $cacheKey = sprintf('user_achievements_%s', $user->getKey());

        return Cache::tags($cacheTag)->remember($cacheKey, 60 * 60 * 24, function () use ($user) {
            $nextAvailableAchievements = $this->achievementRepository->findWhereNotInIds(
                $user->achievements->pluck('id')->all()
            )->toArray();
            $nextBadge = $user->currentBadge ?
                $user->currentBadge :
                $this->badgeRepository->findFirstBadge();
            $remainingAchievementsForNextBadge = $nextBadge ?
                ($nextBadge->total_achievements - $user->achievements()->count()) :
                0;

            return response()->json([
                'unlocked_achievements'                       => $user->achievements->toArray(),
                'next_available_achievements'                 => $nextAvailableAchievements,
                'current_badge'                               => $user->currentBadge?->toArray(),
                'next_badge'                                  => $nextBadge?->toArray(),
                'remaining_achievements_to_unlock_next_badge' => $remainingAchievementsForNextBadge,
            ]);
        });
    }
}
