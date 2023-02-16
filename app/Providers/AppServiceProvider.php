<?php

namespace App\Providers;

use App\Models\Achievement;
use App\Models\Badge;
use App\Models\User;
use App\Repository\AchievementRepository;
use App\Repository\BadgeRepository;
use App\Repository\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(UserRepository::class, function () {
            return new UserRepository(User::class);
        });

        $this->app->singleton(BadgeRepository::class, function () {
            return new BadgeRepository(Badge::class);
        });

        $this->app->singleton(AchievementRepository::class, function () {
            return new AchievementRepository(Achievement::class);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
