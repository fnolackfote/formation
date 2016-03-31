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
                $password,
                $FAC_firstname,
                $FAC_email,
                $FAC_id,
                $FAC_username,
                $FAC_password,
                $FAC_rule;

    const RULE_ADMIN = 1;
    const SALT = '$2x$';

    public function isValid()
    {
        return !(empty($this->FAC_lastname) || empty($this->FAC_firstname));
    }

    public function isValidConnectify()
    {
        return !(empty($this->FAC_username) || empty($this->FAC_password) || empty($this->password)) && ($this->password == $this->FAC_password);
    }

    public function FAC_firstname()
    {
        return $this->FAC_firstname;
    }

    public function FAC_lastname()
    {
        return $this->FAC_lastname;
    }

    public function FAC_username()
    {
        return $this->FAC_username;
    }

    public function FAC_id()
    {
        return $this->FAC_id;
    }

    public function FAC_password()
    {
        return $this->FAC_password;
    }

    public function password()
    {
        return $this->password;
    }

    public function FAC_email()
    {
        return $this->FAC_email;
    }

    public function FAC_rule()
    {
        return $this->FAC_rule;
    }

    public function setFAC_rule($rule)
    {
        $this->FAC_rule = $rule;
    }

    public function setFAC_email($email)
    {
        $this->FAC_email = $email;
    }

    public function setFAC_id($id)
    {
        $this->FAC_id = $id;
    }

    public function setFAC_firstname($firstname)
    {
        $this->FAC_firstname = $firstname;
    }

    public function setFAC_lastname($lastname)
    {
        $this->FAC_lastname = htmlentities(trim($lastname));
    }

    public function setFAC_password($password)
    {
        $this->FAC_password = htmlentities(trim($password));
    }

    public function setPassword($password)
    {
        $this->password = htmlentities(trim($password));
    }

    public function setFAC_username($username)
    {
        $this->FAC_username = htmlentities(trim($username));
    }
}