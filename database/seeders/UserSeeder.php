<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'test@gmail.com',
            'password' => bcrypt('123456'),
            'name' => 'Test'
        ]);
        User::create([
            'email' => 'hiep@gmail.com',
            'password' => bcrypt('123456'),
            'name' => 'Hiệp'
        ]);
    }
}
