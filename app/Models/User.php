<?php

declare(strict_types=1);

namespace App\Models;

use App\Relation\Achievement\BelongsToManyAchievementsTrait;
use App\Relation\Badge\BelongsToManyBadgesTrait;
use App\Relation\BelongsToManyMeta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property string $password
 * @property int    $lessons_watched
 * @property int    $comments_written
 * @property Badge  $currentBadge
 */
class User extends Authenticatable
{
    use HasApiTokens,
        HasFactory,
        Notifiable;

    use BelongsToManyBadgesTrait,
        BelongsToManyAchievementsTrait;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected $attributes = [
        'lessons_watched'  => 0,
        'comments_written' => 0,
    ];

    public function currentBadge(): BelongsTo
    {
        return $this->belongsTo(Badge::class);
    }

    protected function belongsToManyAchievementsMeta(): BelongsToManyMeta
    {
        return new BelongsToManyMeta(
            table          : 'user_achievements',
            foreignPivotKey: 'user_id',
            relatedPivotKey: 'achievement_id',
        );
    }

    protected function belongsToManyBadgeMeta(): BelongsToManyMeta
    {
        return new BelongsToManyMeta(
            table          : 'user_badges',
            foreignPivotKey: 'user_id',
            relatedPivotKey: 'badge_id',
        );
    }
}
