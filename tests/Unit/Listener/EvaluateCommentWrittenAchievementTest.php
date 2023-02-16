<?php

declare(strict_types=1);

namespace Tests\Unit\Listener;

use App\Events\CommentWritten;
use App\Models\User;
use Database\Seeders\AchievementSeeder;
use Database\Seeders\BadgeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

/**
 * @author  Aldi Arief <aldiarief598@gmail.com>
 */
class EvaluateCommentWrittenAchievementTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccess(): void
    {
        $this->seed([
            AchievementSeeder::class,
            BadgeSeeder::class,
        ]);

        Mail::fake();

        /** @var User $user */
        $user = User::factory()->create([
            'comments_written' => 5,
        ]);

        event(new CommentWritten($user));

        $this->assertDatabaseCount('user_achievements', 2);
        $this->assertDatabaseHas('user_achievements', [
            'user_id' => $user->getKey(),
        ]);

        $this->assertDatabaseCount('user_badges', 1);
        $this->assertDatabaseHas('user_badges', [
            'user_id' => $user->getKey(),
        ]);

        $user->refresh();

        $this->assertNotNull($user->currentBadge);
    }
}
