<?php

namespace Tests;

use Closure;
use DOMDocument;
use DOMNodeList;
use DOMXPath;
use Illuminate\Foundation\Testing\Assert as PHPUnit;
use Symfony\Component\CssSelector\CssSelectorConverter;

class TestResponseMixin
{
    public function assertElementCount(): Closure
    {
        return function (string $selector, int $count = 1): self {
            $elements = $this->getElements($selector);

            PHPUnit::assertEquals(
                $count,
                $elements->length,
                "Failed to assert that the response contained {$count} elements matching the selector '{$selector}'."
            );

            return $this;
        };
    }

    public function getElements(): Closure
    {
        return function (string $selector): DOMNodeList {
            $dom = new DOMDocument();

            @$dom->loadHTML(
                mb_convert_encoding($this->getContent(), 'HTML-ENTITIES', 'UTF-8'),
                LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
            );

            $xpath = new DOMXPath($dom);
            $converter = new CssSelectorConverter();
            $xpathSelector = $converter->toXPath($selector);

            $elements = $xpath->query($xpathSelector);

            return $elements;
        };
    }
}
