<?php

if (!function_exists('pp'))
{
    function pp($value)
    {
        echo '<pre>';
        print_r($value);
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