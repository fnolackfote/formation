<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 04/03/2016
 * Time: 13:11
 */

namespace OCFram;

abstract class Field
{
    use Hydrator;

    protected $errorMessage,
                $label,
                $name,
                $value,
                $length,
                $requir = '',
                $name2 = '',
                $validators = [];


    /**
     * Methode permettant de construire un widget assoicie.
     * @return void
     */
    abstract public function buildWidget();

    public function __construct(array $options = [])
    {
        if(!empty($options))
        {
            $this->hydrate($options);
        }
    }

    public function isValid()
    {
        foreach($this->validators as $validator)
        {
            if(!$validator->isValid($this->value))
            {
                $this->errorMessage = $validator->errorMessage();
                return false;
            }
        }
        return true;
    }

    public function label()
    {
        return $this->label;
    }

    public function name()
    {
        return $this->name;
    }

    public function value()
    {
        return $this->value;
    }

    public function requir()
    {
        return $this->requir;
    }

    public function length()
    {
        return $this->length;
    }

    public function validators()
    {
        return $this->validators;
    }

    public function setValidators(array $validators)
    {
        foreach($validators as $validator)
        {
            if($validator instanceof Validator && !in_array($validator, $this->validators))
            {
                $this->validators[] = $validator;
            }
        }
    }

    public function setLabel($label)
    {
        if(is_string($label))
        {
            $this->label = $label;
        }
    }

    public function setLength($length)
    {
        $length = (int) $length;
        if($length > 0)
        {
            $this->length = $length;
        }
    }

    public function setName($name)
    {
        if(is_string($name))
        {
            $this->name = $name;
        }
    }

    public function setValue($value)
    {
        if(is_string($value))
        {
            $this->value = $value;
        }
    }

    public function setRequir($requir)
    {
        if(is_string($requir))
        {
            $this->requir = $requir;
        }
    }
}