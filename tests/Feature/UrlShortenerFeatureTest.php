<?php

namespace Tests\Feature;

use Tests\TestCase;

class UrlShortenerFeatureTest extends TestCase
{
    public function test_encode_endpoint()
    {
        $response = $this->postJson('/api/encode', ['url' => 'https://example.com']);

        $response->assertStatus(200)
                 ->assertJsonStructure(['short_url']);
    }

    public function test_decode_endpoint()
    {
        $encodedResponse = $this->postJson('/api/encode', ['url' => 'https://example.com']);
        $shortUrl = $encodedResponse->json('short_url');

        $response = $this->postJson('/api/decode', ['short_url' => $shortUrl]);
        $response->assertStatus(200)
                 ->assertJson(['original_url' => 'https://example.com']);
    }
}
