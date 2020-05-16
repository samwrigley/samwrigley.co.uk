<?php

use App\NewsletterSubscription;
use Illuminate\Database\Seeder;

class NewsletterSubscriptionsTableSeeder extends Seeder
{
    public function run(): void
    {
        factory(NewsletterSubscription::class, 20)->create();
    }
}
