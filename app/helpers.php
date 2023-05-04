<?php

if (!function_exists('visitsService')) {
    function visitsService($subject, $tag = 'visits'): \App\Services\Visits\Visits
    {
        return new \App\Services\Visits\Visits($subject, $tag);
    }
}
