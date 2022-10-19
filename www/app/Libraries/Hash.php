<?php

namespace App\Libraries;

class Hash
{
    public static function hash($pw)
    {
        return password_hash($pw, PASSWORD_BCRYPT);
    }

    public static function verify($pw, $hash)
    {
        // security
        return password_verify($pw, $hash);
    }
}