<?php

declare(strict_types=1);

namespace App\Models;

use App\Relation\User\BelongsToUserTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $level
 */
class Achievement extends Model
{
    use HasFactory;

    use BelongsToUserTrait;

    public $timestamps = false;
}
