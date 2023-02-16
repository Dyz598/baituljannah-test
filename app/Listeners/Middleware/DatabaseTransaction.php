<?php

declare(strict_types=1);

namespace App\Listeners\Middleware;

use Illuminate\Support\Facades\DB;

/**
 * @author  Aldi Arief <aldiarief598@gmail.com>
 */
class DatabaseTransaction
{
    public function handle(mixed $job, callable $next)
    {
        return DB::transaction(function () use ($job, $next) {
            return $next($job);
        });
    }
}
