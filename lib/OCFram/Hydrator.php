<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 04/03/2016
 * Time: 12:56
 */

namespace OCFram;

trait Hydrator
{
    public function hydrate($data)
    {
        foreach($data as $key => $value)
        {
            $method = 'set'.ucfirst($key);

            if(is_callable([$this, $method]))
            {
                $this->$method($value);
            }
        }
    }

}