<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Category;
use App\Models\Source;
use App\Models\User;
use App\Models\UserSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'admin@innoscripta.com'],
            [
                'name' => 'Innoscripta Admin',
                'email' => 'admin@innoscripta.com',
                'password' => Hash::make('secret123'),
            ]
        );

        UserSetting::updateOrCreate(
            ['user_id' => $user->id],
            [
                'user_id' => $user->id,
                'categories' => [Category::first()->id],
                'sources' => [Source::first()->id],
                'authors' => [Author::first()->id],
            ]
        );
    }
}
