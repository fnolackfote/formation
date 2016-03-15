<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 11/03/2016
 * Time: 15:38
 */

namespace OCFram;


class EmailValidator extends Validator
{

    public function __construct($errorMessage)
    {
        parent::__construct($errorMessage);
    }

    public function isValid($value)
    {
        return empty($value) ? true : filter_var($value, FILTER_VALIDATE_EMAIL) ;
    }
}