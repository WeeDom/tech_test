<?php

namespace Tests\Unit;

use Tests\TestCase;

class UrlShortenerUnitTest extends TestCase
{
    public function test_encode_logic()
    {
        $controller = new \App\Http\Controllers\UrlShortenerController();
        $shortCode = $controller->encode(new \Illuminate\Http\Request(['url' => 'https://example.com']))->getData()->short_url;

        $this->assertNotEmpty($shortCode);
        $this->assertStringContainsString('http://shortened.tld/', $shortCode);
    }

    public function test_decode_logic()
    {
        $controller = new \App\Http\Controllers\UrlShortenerController();
        $shortCode = $controller->encode(new \Illuminate\Http\Request(['url' => 'https://example.com']))->getData()->short_url;
        $decodedUrl = $controller->decode(new \Illuminate\Http\Request(['short_url' => $shortCode]))->getData()->original_url;

        $this->assertEquals('https://example.com', $decodedUrl);
    }
}
