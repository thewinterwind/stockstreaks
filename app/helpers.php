<?php

if (!function_exists('pp'))
{
    function pp($value)
    {
        echo '<pre>';
        print_r($value);
    }
}
