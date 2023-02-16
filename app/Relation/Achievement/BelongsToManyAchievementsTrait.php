<?php

declare(strict_types=1);

namespace App\Relation\Achievement;

use App\Models\Achievement;
use App\Relation\BelongsToManyMeta;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin HasRelationships
 *
 * @property Collection|Achievement[] $achievements
 *
 * @author  Aldi Arief <aldiarief598@gmail.com>
 */
trait BelongsToManyAchievementsTrait
{
    public function achievements(): BelongsToMany
    {
        return $this->belongsToMany(
            Achievement::class,
            ...$this->belongsToManyAchievementsMeta()->toArray()
        );
    }

    protected function belongsToManyAchievementsMeta(): BelongsToManyMeta
    {
        return new BelongsToManyMeta();
    }
}
