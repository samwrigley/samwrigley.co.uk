<?php

namespace Database\Seeders\Dev;

use App\Models\NewsletterSubscription;
use Illuminate\Database\Seeder;

class NewsletterSubscriptionsTableSeeder extends Seeder
{
    public function run(): void
    {
        NewsletterSubscription::factory()->count(20)->create();
    }
}
