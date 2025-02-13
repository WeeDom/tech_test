<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class UrlShortenerController extends Controller
{
    public function encode(Request $request)
    {
        $request->validate(['url' => 'required|url']);
        $originalUrl = $request->input('url');

        $shortCode = $this->generateShortCode($originalUrl);
        Redis::setex("short:$shortCode", 86400, $originalUrl); // Store in Redis with 1-day expiry

        return response()->json(['short_url' => "http://{$shortCode}"]);
    }

    public function decode(Request $request)
    {
        $request->validate(['short_url' => 'required']);
        $shortUrl = str_replace('http://', '', $request->input('short_url'));
        
        $originalUrl = Redis::get("short:$shortUrl");
        if (!$originalUrl) {
            return response()->json(['error' => 'Short URL not found'], 404);
        }

        return response()->json(['original_url' => $originalUrl]);
    }

    private function generateShortCode($url)
    {
        $md5Hash = md5($url);
        $base62 = base_convert(substr($md5Hash, 0, 10), 16, 36); // Convert hex to base62-like
        $short = substr($base62, 0, 5);
        $tld = substr($base62, 5, 3);
        return "{$short}.{$tld}";
    }
}