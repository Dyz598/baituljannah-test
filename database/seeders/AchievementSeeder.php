<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enum\AchievementType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AchievementSeeder extends Seeder
{
    protected array $data = [
        [
            'id'    => 1,
            'type'  => AchievementType::LESSON_WATCHED,
            'level' => 1,
            'total' => 2,
        ],
        [
            'id'    => 2,
            'type'  => AchievementType::LESSON_WATCHED,
            'level' => 2,
            'total' => 5,
        ],
        [
            'id'    => 3,
            'type'  => AchievementType::LESSON_WATCHED,
            'level' => 3,
            'total' => 7,
        ],
        [
            'id'    => 4,
            'type'  => AchievementType::LESSON_WATCHED,
            'level' => 4,
            'total' => 9,
        ],
        [
            'id'    => 5,
            'type'  => AchievementType::LESSON_WATCHED,
            'level' => 5,
            'total' => 10,
        ],
        [
            'id'    => 6,
            'type'  => AchievementType::COMMENT_WRITTEN,
            'level' => 1,
            'total' => 2,
        ],
        [
            'id'    => 7,
            'type'  => AchievementType::COMMENT_WRITTEN,
            'level' => 2,
            'total' => 5,
        ],
        [
            'id'    => 8,
            'type'  => AchievementType::COMMENT_WRITTEN,
            'level' => 3,
            'total' => 7,
        ],
        [
            'id'    => 9,
            'type'  => AchievementType::COMMENT_WRITTEN,
            'level' => 4,
            'total' => 9,
        ],
        [
            'id'    => 10,
            'type'  => AchievementType::COMMENT_WRITTEN,
            'level' => 5,
            'total' => 10,
        ],
    ];

    public function run()
    {
        DB::table('achievements')
            ->upsert($this->data, ['id']);
    }
}
