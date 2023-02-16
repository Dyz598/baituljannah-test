<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BadgeSeeder extends Seeder
{
    protected array $data = [
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
        [
            'id'                 => 4,
            'name'               => 'master',
            'total_achievements' => 10,
            'previous_badge_id'  => 3,
        ]
    ];

    public function run()
    {
        foreach ($this->data as $datum) {
            DB::table('badges')
                ->insert($datum);
        }
    }
}
