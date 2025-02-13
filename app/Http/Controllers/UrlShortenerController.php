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

        return response()->json(['short_url' => "http://shortened.tld/{$shortCode}"]);
    }

    public function decode(Request $request)
    {
        $request->validate(['short_url' => 'required']);
        $shortUrl = str_replace('http://shortened.tld/', '', $request->input('short_url'));

        if (!isset(self::$urlMap[$shortUrl])) {
            return response()->json(['error' => 'Short URL not found'], 404);
        }

        return response()->json(['original_url' => self::$urlMap[$shortUrl]]);
    }

    private function generateShortCode($url)
    {
        return substr(base_convert(md5($url), 16, 36), 0, 7);
    }
}