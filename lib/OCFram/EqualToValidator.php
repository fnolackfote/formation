<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 11/03/2016
 * Time: 13:11
 */

namespace OCFram;

class EqualToValidator extends Validator
{
    protected $value;

    public function __construct($errorMessage, $func)
    {
        parent::__construct($errorMessage);
    }

    public function isValid($value)
    {
        return $this->value = $value;
    }

    public function setValue($val)
    {
        $this->value = $val;
    }
}