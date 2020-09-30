<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactsTableSeeder extends Seeder
{
    public function run(): void
    {
        Contact::factory()->count(10)->create();
    }
}
