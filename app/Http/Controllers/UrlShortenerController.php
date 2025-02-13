<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UrlShortenerController extends Controller
{
    protected static $urlMap = [];

    public function encode(Request $request)
    {
        $request->validate(['url' => 'required|url']);
        $originalUrl = $request->input('url');

        $shortCode = $this->generateShortCode($originalUrl);
        self::$urlMap[$shortCode] = $originalUrl;

        return response()->json(['short_url' => "http://{$shortCode}"]);
    }

    public function decode(Request $request)
    {
        $request->validate(['short_url' => 'required']);
        $shortUrl = str_replace('http://', '', $request->input('short_url'));

        if (!isset(self::$urlMap[$shortUrl])) {
            return response()->json(['error' => 'Short URL not found'], 404);
        }

        return response()->json(['original_url' => self::$urlMap[$shortUrl]]);
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