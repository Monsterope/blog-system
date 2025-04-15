<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt("admin1234"),
            'role' => "admin"
        ]);

        Blog::create([
            "title" => "Demo working",
            "contents" => "Hello world"
        ]);
        sleep(1);
        Blog::create([
            "title" => "Demo working 1",
            "contents" => "Hello world 1"
        ]);
        sleep(1);
        Blog::create([
            "title" => "Demo working 2",
            "contents" => "Hello world 2"
        ]);
    }
}
