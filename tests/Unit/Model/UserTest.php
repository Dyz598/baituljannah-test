<?php

declare(strict_types=1);

namespace Tests\Unit\Model;

use App\Models\User;
use Database\Seeders\AchievementSeeder;
use Database\Seeders\BadgeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * @author  Aldi Arief <aldiarief598@gmail.com>
 */
class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testRelations(): void
    {
        $this->seed([
            AchievementSeeder::class,
            BadgeSeeder::class,
        ]);

        $badge = DB::table('badges')->first();
        $achievement = DB::table('achievements')->first();

        DB::table('users')
            ->insert([
                'id'               => 1,
                'name'             => fake()->name,
                'email'            => fake()->email,
                'password'         => Hash::make(fake()->password),
                'current_badge_id' => $badge->id,
            ]);

        DB::table('user_achievements')
            ->insert([
                'user_id'        => 1,
                'achievement_id' => $achievement->id,
            ]);

        DB::table('user_badges')
            ->insert([
                'user_id'        => 1,
                'badge_id' => $badge->id,
            ]);

        /** @var User $user */
        $user = User::first();

        $this->assertNotNull($user->currentBadge);
        $this->assertEquals($user->achievements->count(), 1);
        $this->assertEquals($user->badges->count(), 1);
    }
}
