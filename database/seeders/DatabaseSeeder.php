<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::factory(5)->create();

        $this->callOnce([
            BadgeSeeder::class,
            AchievementSeeder::class,
        ]);
    }
}
