<?php

function cast_to_json($json)
{
    // Convert from array to json and add slashes, if necessary.
    if (is_array($json)) {
        $json = addslashes(json_encode($json));
    } // Or check if the value is malformed.
    elseif (is_null($json) || is_null(json_decode($json))) {
        throw new Exception('A valid JSON string was not provided.');
    }

    return DB::raw("CAST('{$json}' AS JSON)");
}
