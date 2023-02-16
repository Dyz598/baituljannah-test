<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Middleware;

use App\Http\Middleware\DatabaseTransaction;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * @author  Aldi Arief <aldiarief598@gmail.com>
 */
class DatabaseTransactionTest extends TestCase
{
    public function testSuccess(): void
    {
        $middleware = new DatabaseTransaction();

        $middleware->handle(
            request(),
            function () {
                $this->assertEquals(
                    DB::transactionLevel(),
                    1
                );
            }
        );
    }
}
