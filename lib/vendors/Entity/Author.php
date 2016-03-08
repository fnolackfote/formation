<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 08/03/2016
 * Time: 12:46
 */

namespace Entity;


use \OCFram\Entity;

class Author extends Entity
{
    protected $FAC_lastname,
                $FAC_firstname,
                $FAC_username,
                $FAC_password;

    public function isValid()
    {
        return !(empty($this->FAC_lastname) || empty($this->FAC_firstname));
    }

    public function isValidConnectify()
    {
        return !(empty($this->FAC_username) || empty($this->FAC_password));
    }

    public function FAC_firstname()
    {
        return trim($this->FAC_firstname);
    }

    public function FAC_lastname()
    {
        return trim($this->FAC_lastname);
    }

    public function FAC_username()
    {
        return trim($this->FAC_username);
    }

    public function FAC_password()
    {
        return crypt(trim($this->FAC_password));
    }

    public function setFAC_firstname($firstname)
    {
        $this->FAC_firstname = $firstname;
    }

    public function setFAC_lastname($lastname)
    {
        $this->FAC_lastname = $lastname;
    }

    public function setFAC_password($password)
    {
        $this->FAC_password = $password;
    }

    public function setFAC_username($username)
    {
        $this->FAC_username = $username;
    }
}