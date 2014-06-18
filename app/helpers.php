<?php

if (!function_exists('pp'))
{
    function pp($value)
    {
        echo '<pre>';
        var_dump($value);
    }
}

if (!function_exists('ppd'))
{
    function ppd($value)
    {
        pp($value);
        die;
    }
}