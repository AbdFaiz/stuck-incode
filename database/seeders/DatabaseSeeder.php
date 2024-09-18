<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tag;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(50)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin.admin'),
        ]);

        User::create([
            'name' => 'domm',
            'email' => 'dom@gmail.com',
            'password' => bcrypt('password'),
        ]);

        Tag::create([
            'name' => 'laravel',
        ]);

        Tag::create([
            'name' => 'json',
        ]);

        Tag::create([
            'name' => 'php',
        ]);
    }
}
