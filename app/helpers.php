<?php

if (!function_exists('visitsService')) {
    function visitsService($subject, $tag = 'visits'): \App\Services\Visits\Visits
    {
        return new \App\Services\Visits\Visits($subject, $tag);
    }
}

if (!function_exists('format_long_numbers')) {
    function format_long_numbers($n, $precision = 3): string
    {
        if ($n < 1000000) {
            return number_format($n);
        }

        // Anything less than a billion
        if ($n < 1000000000) {
            return number_format($n / 1000000, $precision).'M';
        }

        // At least a billion
        return number_format($n / 1000000000, $precision).'B';
    }
}
