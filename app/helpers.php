<?php

if (! function_exists('errorClass')) {
    function errorClass($field, $class = 'has-error')
    {
        return session('errors') && session('errors')->has($field) ? $class : '';
    }
}

if (! function_exists('formatViews')) {
    function formatViews(int $views)
    {
        if ($views >= 1000000) {
            return $views / 1000000 .'m';
        } elseif ($views >= 1000) {
            return $views / 1000 .'k';
        } else {
            return $views;
        }
    }
}
