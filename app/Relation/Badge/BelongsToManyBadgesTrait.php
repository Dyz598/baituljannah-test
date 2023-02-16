<?php

declare(strict_types=1);

namespace App\Relation\Badge;

use App\Models\Badge;
use App\Relation\BelongsToManyMeta;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin HasRelationships
 *
 * @property Collection|Badge[] $badges
 *
 * @author  Aldi Arief <aldiarief598@gmail.com>
 */
trait BelongsToManyBadgesTrait
{
    public function badges(): BelongsToMany
    {
        return $this->belongsToMany(
            Badge::class,
            ...$this->belongsToManyBadgeMeta()->toArray()
        );
    }

    protected function belongsToManyBadgeMeta(): BelongsToManyMeta
    {
        return new BelongsToManyMeta();
    }
}
