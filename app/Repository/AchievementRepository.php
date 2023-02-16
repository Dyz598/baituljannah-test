<?php

declare(strict_types=1);

namespace App\Repository;

use App\Enum\AchievementType;
use Illuminate\Database\Eloquent\Collection;

/**
 * @author  Aldi Arief <aldiarief598@gmail.com>
 */
class AchievementRepository extends Repository
{
    public function findWhereNotInIds(array $ids): Collection
    {
        $query = $this->createQueryBuilder();

        $query->whereNotIn('id', $ids);

        return $query->get();
    }

    public function findAchievedByTypeAndTotal(AchievementType $type, int $total): Collection
    {
        $query = $this->createQueryBuilder();

        $query
            ->where('type', $type)
            ->where('total', '<=', $total);

        return $query->get();
    }
}
