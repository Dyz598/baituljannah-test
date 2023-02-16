<?php

declare(strict_types=1);

namespace App\Models;

use App\Relation\User\BelongsToUserTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property string $name
 * @property int    $total_achievements
 * @property Badge  $previousBadge
 * @property Badge  $nextBadge
 */
class Badge extends Model
{
    use HasFactory;

    use BelongsToUserTrait;

    public $timestamps = false;

    public function previousBadge(): BelongsTo
    {
        return $this->belongsTo(Badge::class, 'previous_badge_id');
    }

    public function nextBadge(): HasOne
    {
        return $this->hasOne(Badge::class, 'previous_badge_id');
    }
}
