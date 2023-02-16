<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserObserver
{
    public function saved(User $user)
    {
        Cache::tags(sprintf('user_%s', $user->getKey()))->flush();
    }
}
