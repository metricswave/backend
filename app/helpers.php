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

if (!function_exists('random_item_from_weighted_array')) {
    function random_item_from_weighted_array(array $items): mixed
    {
        $weights = array_values($items); // Extract weights
        $items = array_keys($items); // Extract items

        $weightSum = array_sum($weights);
        $cumulativeWeights = array();
        $cumulativeWeight = 0;

        foreach ($weights as $weight) {
            $cumulativeWeight += $weight / $weightSum;
            $cumulativeWeights[] = $cumulativeWeight;
        }

        $rand = mt_rand() / mt_getrandmax();

        foreach ($cumulativeWeights as $key => $weight) {
            if ($rand < $weight) {
                return $items[$key];
            }
        }

        return $items[0];
    }
}
