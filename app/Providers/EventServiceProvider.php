<?php

namespace App\Providers;

use App\Events\CommentWritten;
use App\Events\LessonWatched;
use App\Listeners\EvaluateCommentWrittenAchievement;
use App\Listeners\EvaluateLessonWatchedAchievement;
use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
//        Registered::class     => [
//            SendEmailVerificationNotification::class,
//        ],
        CommentWritten::class => [
            EvaluateCommentWrittenAchievement::class,
        ],
        LessonWatched::class  => [
            EvaluateLessonWatchedAchievement::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
