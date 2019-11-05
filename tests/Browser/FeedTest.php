<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class FeedTest extends DuskTestCase
{
    /** @test */
    public function can_see_feed_link_tag(): void
    {
        $this->browse(function (Browser $browser): void {
            $hasLink = $browser
                ->visitRoute('home')
                ->hasElement('link[type="application/rss+xml"]');

            $this->assertTrue($hasLink);
        });
    }
}
