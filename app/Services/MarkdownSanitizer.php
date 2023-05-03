<?php

namespace App\Services;

class MarkdownSanitizer
{
    public static function sanitize(string $text): string
    {
        $text = preg_replace('/\_/', '\\\\_', $text);
        $text = preg_replace('/\*/', '\\\\*', $text);
        $text = preg_replace('/\[/', '\\\\[', $text);
        $text = preg_replace('/\]/', '\\\\]', $text);
        $text = preg_replace('/\(/', '\\\\(', $text);
        $text = preg_replace('/\)/', '\\\\)', $text);
        $text = preg_replace('/\~/', '\\\\~', $text);
        $text = preg_replace('/\`/', '\\\\`', $text);
        $text = preg_replace('/\>/', '\\\\>', $text);
        $text = preg_replace('/\#/', '\\\\#', $text);
        $text = preg_replace('/\+/', '\\\\+', $text);
        $text = preg_replace('/\-/', '\\\\-', $text);
        $text = preg_replace('/\=/', '\\\\=', $text);
        $text = preg_replace('/\|/', '\\\\|', $text);
        $text = preg_replace('/\{/', '\\\\{', $text);
        $text = preg_replace('/\}/', '\\\\}', $text);
        $text = preg_replace('/\./', '\\\\.', $text);
        $text = preg_replace('/\!/', '\\\\!', $text);

        return $text;
    }
}
