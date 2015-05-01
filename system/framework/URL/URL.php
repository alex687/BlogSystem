<?php

namespace URL;


class URL
{
    public static function asset($url)
    {
        $requestHome = dirname($_SERVER['PHP_SELF']);

        return $requestHome . '/' . $url;
    }

    public static function url($url)
    {
        $requestHome = dirname($_SERVER['PHP_SELF']);

        return $requestHome . '/' . $url;
    }

    public static function redirect($url)
    {
        http_response_code(302);
        $requestHome = dirname($_SERVER['PHP_SELF']);
        header("Location :" . $_SERVER['HTTP_ORIGIN'] . $requestHome . '/' . $url);
        die();
    }
}