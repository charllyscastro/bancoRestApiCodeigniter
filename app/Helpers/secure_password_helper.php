<?php

if (!function_exists("hashPassword")) {
    function hashPassword($plainText)
    {
        return password_hash($plainText, PASSWORD_BCRYPT);
    }
}

if (!function_exists("verifyPassword")) {
    function verifyPassword($plainText, $hash)
    {
        return password_verify($plainText, $hash);
    }
}
