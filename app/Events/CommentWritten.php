<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\User;
use Illuminate\Queue\SerializesModels;

class CommentWritten
{
    use SerializesModels;

    public function __construct(
        public readonly User $user,
    ) {}
}
