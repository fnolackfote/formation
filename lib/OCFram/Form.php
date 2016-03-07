<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 04/03/2016
 * Time: 13:04
 */

namespace OCFram;


class Form
{
    protected $entity,
              $fields = [];

    public function __construct(Entity $entity)
    {
        $this->setEntity($entity);
    }

    public function add(Field $field)
    {
        $attr = $field->name();
        $field->setValue($this->entity->$attr());
        $this->fields[] = $field;
        return $this;
    }

    public function createview()
    {
        $view = '';

        foreach($this->fields as $field)
        {
            $view .= $field->buildWidget().'<br />';
        }

        return $view;
    }

    public function isValid()
    {
        $valid = true;

        foreach($this->fields as $field)
        {
            if(!$field->isValid())
            {
                $valid = false;
            }
        }

        return $valid;
    }

    public function entity()
    {
        return $this->entity;
    }

    public function setEntity(Entity $entity)
    {
        $this->entity = $entity;
    }

}