<?php

namespace Database;

class FilterVariables
{
    public static function email($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function minLength($var, $minLength)
    {
        return strlen($var) > $minLength;
    }
}