<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Sam Wrigley',
            'slug' => 'sam-wrigley',
            'email' => 'test@example.com',
            'password' => bcrypt('secret'),
        ]);
    }
}
