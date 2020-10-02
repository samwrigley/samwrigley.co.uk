<?php

namespace Tests\Unit;

use App\Services\CommonMark\CommonMark;
use Tests\TestCase;

class CommonMarkTest extends TestCase
{
    /** @test */
    public function it_converts_markdown_to_html(): void
    {
        $html = CommonMark::convertToHtml('# Heading');

        $this->assertEquals($html, "<h1>Heading</h1>\n");
    }
}
