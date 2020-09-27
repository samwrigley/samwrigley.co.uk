<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class UsersTableTestSeeder extends Seeder
{
    public function run(): void
    {
        factory(User::class)->create([
            'name' => 'Sam Wrigley',
            'slug' => 'sam-wrigley',
            'email' => Config::get('contact.email'),
            'password' => bcrypt('secret'),
        ]);
    }
}
