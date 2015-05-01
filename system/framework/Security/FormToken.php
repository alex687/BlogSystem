<?php

namespace Security;

class FormToken
{
    public static function generateToken()
    {
        $token = md5(mt_rand(1, 1000000));

        return $token;
    }
}