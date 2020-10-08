<?php

if (!function_exists('clean_string')) {
    function clean_string($string)
    {
        return trim(addslashes($string));
    }
}

if(!function_exists('getPlaceholder')) {
    function getPlaceholder($field) {
        return $field['placeholder'] ?? 'Enter ' . \Illuminate\Support\Str::of($field['name'])->title()->lower();
    }
}