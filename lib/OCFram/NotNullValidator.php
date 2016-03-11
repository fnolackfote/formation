<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 04/03/2016
 * Time: 15:22
 */

namespace OCFram;


class NotNullValidator extends Validator
{
    public function isValid($value)
    {
        // return !($value == '');
        return $value != '';
    }
}