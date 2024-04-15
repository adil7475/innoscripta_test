<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Category;
use App\Models\News;
use App\Models\Source;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory()
            ->count(5)
            ->create();

        Source::factory()
            ->count(5)
            ->create();

        Author::factory()
            ->count(5)
            ->create();

        News::factory()
            ->count(30)
            ->create();
    }
}
