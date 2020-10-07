<?php

if (!function_exists('clean_string')) {
    function clean_string($string)
    {
        return trim(addslashes($string));
    }
}
