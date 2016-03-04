<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 04/03/2016
 * Time: 14:14
 */

namespace OCFram;

class TextField extends Field
{
    protected $cols,
                $rows;

    public function buildWidget()
    {
        // TODO: Implement buildWidget() method.
        $widget = '';

        if(!empty($this->errorMessage))
        {
            $widget .= $this->errorMessage.'<br />';
        }

        $widget .= '<label>'.$this->label.'</label><textarea name="'.$this->name.'"';

        if(!empty($this->cols))
        {
            $widget .= ' cols="'.$this->cols.'"';
        }

        if(!empty($this->rows))
        {
            $widget .= ' rows="'.$this->rows.'"';
        }

        $widget .= '>';

        if(!empty($this->value))
        {
            $widget .= htmlspecialchars($this->value);
        }

        return $widget.'</textarea>';
    }

    public function setCols($cols)
    {
        $cols = (int) $cols;

        if($cols > 0)
        {
            $this->cols = $cols;
        }
    }

    public function setRows($rows)
    {
        $rows = (int) $rows;

        if($rows > 0)
        {
            $this->rows = $rows;
        }
    }
}