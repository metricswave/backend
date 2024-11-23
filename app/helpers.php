<?php

if (! function_exists('html_format_currency')) {
    function html_format_currency(int $amount, string $symbol, string $suffix = ''): string
    {
        $exploded = explode(',', number_format($amount / 100, 2, ',', '.'));
        $main = $exploded[0];
        $cents = $exploded[1];
        $preSymbol = $symbol === '€' ? '' : '<span class="text-base opacity-90">'.$symbol.'</span>';
        $postSymbol = $symbol === '€' ? '<span class="text-base opacity-90">'.$symbol.'</span>' : '';
        $suffix = $suffix === '' ? '' : '<span class="text-base -ml-0.5 opacity-80">'.$suffix.'</span>';

        return <<<HTML
{$preSymbol}<span>{$main}</span><span class="text-base -ml-0.5 opacity-80">.{$cents}</span>{$postSymbol}{$suffix}
HTML;
    }
}

if (! function_exists('format_long_numbers')) {
    function format_long_numbers($n, $precision = 3, bool $long_format = false): string
    {
        if ($n < 1000000 || $long_format) {
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

if (! function_exists('random_item_from_weighted_array')) {
    function random_item_from_weighted_array(array $items): mixed
    {
        $weights = array_values($items); // Extract weights
        $items = array_keys($items); // Extract items

        $weightSum = array_sum($weights);
        $cumulativeWeights = [];
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

if (! function_exists('safe_url')) {
    function safe_url(string $url): string
    {
        return preg_replace('/([^:])(\/{2,})/', '$1/', $url);
    }
}
