<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 04/03/2016
 * Time: 15:25
 */

namespace OCFram;


class MaxLengthValidator extends Validator
{
    protected $maxLength;

    public function __construct($errorMessage, $maxLength)
    {
        parent::__construct($errorMessage);

        $this->setMaxLength($maxLength);
    }

    public function isValid($value)
    {
        // TODO: Implement isValid() method.
        return strlen($value);
    }

    public function setMaxLength($maxLength)
    {
        $maxLength = (int) $maxLength;

        if($maxLength > 0)
        {
            $this->maxLength;
        }
        else
        {
            throw new \RuntimeException('La longueur maximale doit être supérieure à 0');
        }
    }
}