<?php

namespace Database\Seeders;

use Database\Seeders\UserSeeder;
use Database\Seeders\CommentSeeder;
use Database\Seeders\PubSeeder;
use Database\Seeders\PermissionSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(PubSeeder::class);
        $this->call(CommentSeeder::class);
        $this->call(PermissionSeeder::class);
    }
}
