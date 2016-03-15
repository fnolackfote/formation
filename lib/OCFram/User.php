<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 02/03/2016
 * Time: 18:40
 */

namespace OCFram;

session_start();

class User
{

    public function getAttribute($attr)
    {
        return isset($_SESSION[$attr]) ? $_SESSION[$attr] : null;
    }

    public function getFlash()
    {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);

        return $flash;
    }

    public function hasFlash()
    {
        return isset($_SESSION['flash']);
    }

    public function isAuthenticated()
    {
        return isset($_SESSION['auth']) && $_SESSION['auth'] === true;
    }

    public function setSessionUser($value)
    {
        $_SESSION['user_id'] = (int) $value;
    }

    public function sessionUser()
    {
        return $_SESSION['user_id'];
    }

    public function setAttribute($attr, $value)
    {
        $_SESSION[$attr] = $value;
    }

    public function setAuthenticated($authenticated = true)
    {
        if (!is_bool($authenticated))
        {
            throw new \InvalidArgumentException('La valeur spécifiée à la méthode User::setAuthenticated() doit être un boolean');
        }

        $_SESSION['auth'] = $authenticated;
    }

    public function setFlash($value)
    {
        $_SESSION['flash'] = $value;
    }

    public function setRule($rule)
    {
        $_SESSION['rule'] = (int) $rule;
    }

    public function rule()
    {
        return $_SESSION['rule'];
    }
}