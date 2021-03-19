<?php

namespace Database\Seeders\Dev;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Sam Wrigley',
            'slug' => 'sam-wrigley',
            'email' => Config::get('contact.email'),
            'password' => bcrypt('secret'),
        ]);
    }
}
