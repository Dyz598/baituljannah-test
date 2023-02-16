<?php

declare(strict_types=1);

namespace Tests\Unit\Model;

use App\Models\Badge;
use Database\Seeders\BadgeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * @author  Aldi Arief <aldiarief598@gmail.com>
 */
class BadgeTest extends TestCase
{
    use RefreshDatabase;

    public function testRelations(): void
    {
        DB::table('badges')
            ->insert([
                [
                    'id'                 => 1,
                    'name'               => 'beginner',
                    'total_achievements' => 2,
                    'previous_badge_id'  => null,
                ],
                [
                    'id'                 => 2,
                    'name'               => 'intermediate',
                    'total_achievements' => 6,
                    'previous_badge_id'  => 1,
                ],
                [
                    'id'                 => 3,
                    'name'               => 'expert',
                    'total_achievements' => 8,
                    'previous_badge_id'  => 2,
                ],
            ]);

        /** @var Badge $badge */
        $badge = Badge::query()
            ->where('id', 2)
            ->first();

        $this->assertNotNull($badge->previousBadge);
        $this->assertNotNull($badge->nextBadge);
    }
}
