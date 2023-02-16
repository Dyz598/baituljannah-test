<?php

declare(strict_types=1);

namespace App\Service;

use App\Models\Badge;
use App\Models\User;
use App\Repository\BadgeRepository;
use Illuminate\Database\Eloquent\Collection;

/**
 * @author  Aldi Arief <aldiarief598@gmail.com>
 */
class BadgeEvaluator
{
    public function __construct(
        protected readonly BadgeRepository $badgeRepository,
    ) {}

    public function evaluate(User $user): Collection
    {
        $unlockedBadges = $this->badgeRepository
            ->findAchievedByTotal(
                $user->achievements()->count()
            )->mapWithKeys(function (Badge $item) {
                return [$item->getKey() => $item];
            })->all();

        $currentBadges = $user->badges
            ->mapWithKeys(function (Badge $item) {
                return [$item->getKey() => $item];
            })->all();

        foreach ($currentBadges as $key => $currentBadge) {
            if (isset($unlockedBadges[$key])) {
                unset($unlockedBadges[$key]);
            }
        }

        return new Collection($unlockedBadges);
    }
}
