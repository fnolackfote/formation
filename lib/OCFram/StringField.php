<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 04/03/2016
 * Time: 14:04
 */

namespace OCFram;

class StringField extends Field
{
    protected $maxLength,
        $type = 'text';

    public function setType($type)
    {
        if(is_string($type))
        {
            $this->type = $type;
        }
    }

    public function buildWidget()
    {
        $widget = '';
        if(!empty($this->errorMessage))
        {
            $widget .= $this->errorMessage.'<br />';
        }
        $widget .= '<label>'.$this->label.'</label><input type="'.$this->type.'" name="'.$this->name.'"';

        if(!empty($this->value))
        {
            $widget .= ' value="'.htmlspecialchars($this->value).'"';
        }

        if(!empty($this->maxLength))
        {
            $widget .= ' maxlength ="'.$this->maxLength.'"';
        }

        if(!empty($this->requir))
        {
            $widget .= ' require = require ';
        }

        return $widget .= ' />';
    }

    public function setMaxLength($maxLength)
    {
        $maxLength = (int) $maxLength;

        if($maxLength > 0)
        {
            $this->maxLength = $maxLength;
        }
        else
        {
            throw new \RuntimeException('La longueur maximale doit être supérieure a 0');
        }
    }
}