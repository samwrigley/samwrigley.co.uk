<?php

namespace Tests\Unit;

use App\Services\CommonMark\CommonMark;
use Spatie\Snapshots\MatchesSnapshots;
use Tests\TestCase;

class CommonMarkTest extends TestCase
{
    use MatchesSnapshots;

    /** @test */
    public function it_converts_markdown_to_html(): void
    {
        $markdown = <<<'MARKDOWN'
        # Heading
        Some text
        MARKDOWN;

        $html = CommonMark::convertToHtml($markdown);

        $this->assertMatchesXmlSnapshot("<div>{$html}</div>");
    }

    /** @test */
    public function it_highlights_code_in_markdown(): void
    {
        $markdown = <<<'MARKDOWN'
        ```js
        const foo = 'bar';
        ```
        MARKDOWN;

        $html = CommonMark::convertToHtml($markdown);

        $this->assertMatchesXmlSnapshot("<div>{$html}</div>");
    }
}
