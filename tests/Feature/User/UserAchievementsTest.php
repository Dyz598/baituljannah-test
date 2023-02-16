<?php

declare(strict_types=1);

namespace Tests\Feature\User;

use App\Models\Achievement;
use App\Models\Badge;
use App\Models\User;
use Database\Seeders\AchievementSeeder;
use Database\Seeders\BadgeSeeder;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

/**
 * @author  Aldi Arief <aldiarief598@gmail.com>
 */
class UserAchievementsTest extends TestCase
{
    public function testHaveNoAchievements(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $token = $user->createToken('auth')->plainTextToken;

        $response = $this->getJson(
            uri    : sprintf('/api/users/%s/achievements', $user->getKey()),
            headers: [
                'Authorization' => sprintf('Bearer %s', $token)
            ]
        );

        $response->assertStatus(200);

        $cacheTag = sprintf('user_%s', $user->getKey());
        $cacheKey = sprintf('user_achievements_%s', $user->getKey());
        $this->assertNotNull(Cache::tags($cacheTag)->get($cacheKey));
    }

    public function testHaveSomeAchievements(): void
    {
        $this->seed([
            AchievementSeeder::class,
            BadgeSeeder::class,
        ]);

        /** @var User $user */
        $user = User::factory()->create();
        $token = $user->createToken('auth')->plainTextToken;

        $user->achievements()->attach(
            Achievement::query()->whereIn('id', [1, 6])->pluck('id')->all()
        );

        $currentBadge = Badge::query()->where('id', 1)->first();

        $user->badges()->attach([$currentBadge->id]);
        $user->currentBadge()->associate($currentBadge);

        $user->save();

        $response = $this->getJson(
            uri    : sprintf('/api/users/%s/achievements', $user->getKey()),
            headers: [
                'Authorization' => sprintf('Bearer %s', $token)
            ]
        );

        $response->assertStatus(200);

        $cacheTag = sprintf('user_%s', $user->getKey());
        $cacheKey = sprintf('user_achievements_%s', $user->getKey());
        $this->assertNotNull(Cache::tags($cacheTag)->get($cacheKey));
    }
}
