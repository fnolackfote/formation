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
                $value;


    /**
     * Methode permettantr de construire un widget assoicie.
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

    public function setLabel($label)
    {
        if(is_string($label))
        {
            $this->label = $label;
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
}