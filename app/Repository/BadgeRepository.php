<?php

declare(strict_types=1);

namespace App\Repository;

use Illuminate\Database\Eloquent\Collection;

/**
 * @author  Aldi Arief <aldiarief598@gmail.com>
 */
class BadgeRepository extends Repository
{
    public function findFirstBadge()
    {
        $query = $this->createQueryBuilder();

        $query->whereNull('previous_badge_id');

        return $query->first();
    }

    public function findAchievedByTotal(int $total): Collection
    {
        $query = $this->createQueryBuilder();

        $query->where('total_achievements', '<=', $total);

        return $query->get();
    }
}
