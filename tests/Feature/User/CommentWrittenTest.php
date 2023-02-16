<?php

declare(strict_types=1);

namespace Tests\Feature\User;

use App\Events\CommentWritten;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * @author  Aldi Arief <aldiarief598@gmail.com>
 */
class CommentWrittenTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccess(): void
    {
        Event::fake();

        /** @var User $user */
        $user = User::factory()->create();
        $token = $user->createToken('auth')->plainTextToken;

        $this->postJson(
            uri    : sprintf('/api/users/%s/comment', $user->getKey()),
            headers: [
                'Authorization' => sprintf('Bearer %s', $token)
            ]
        );

        Event::assertDispatched(CommentWritten::class);
    }
}
