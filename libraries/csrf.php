<?php
//ANHDUNG
class csrf
{
    static public function createToken()
    {
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(35));
        }
    }

    static public function displayToken()
    {
        return sprintf("<input type='hidden' name='token' value='%s'>", $_SESSION['token']);
    }

    static public function authenticationToken()
    {
        $token = FSInput::get('token');
        if (!$token || $token !== $_SESSION['token']) {
            return false;
        }
        return true;
    }
}
