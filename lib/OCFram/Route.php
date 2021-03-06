<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 01/03/2016
 * Time: 17:32
 */

namespace OCFram;


class Route
{
    protected $action;
    protected $format;
    protected $module;
    protected $url;
    protected $varsNames;
    protected $vars = [];

    public function __construct($url, $module, $action, array $varsNames, $format)
    {
        $this->setUrl($url);
        $this->setModule($module);
        $this->setAction($action);
        $this->setVarsNames($varsNames);
        $this->setFormat($format);
    }

    public function hasVars()
    {
        return !empty($this->varsNames);
    }

    public function match($url)
    {
        if (preg_match('`^'.$this->url.'$`', $url, $matches))
        {
            return $matches;
        }
        else
        {
            return false;
        }
    }

    public function setAction($action)
    {
        if (is_string($action))
        {
            $this->action = $action;
        }
    }

    public function setModule($module)
    {
        if (is_string($module))
        {
            $this->module = $module;
        }
    }

    public function url()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        if (is_string($url))
        {
            $this->url = $url;
        }
    }

    public function setFormat($format)
    {
        if (is_string($format))
        {
            $this->format = $format;
        }
    }

    public function setVarsNames(array $varsNames)
    {
        $this->varsNames = $varsNames;
    }

    public function setVars(array $vars)
    {
        $this->vars = $vars;
    }

    public function action()
    {
        return $this->action;
    }

    public function module()
    {
        return $this->module;
    }

    public function vars()
    {
        return $this->vars;
    }

    public function format()
    {
        return $this->format;
    }

    public function varsNames()
    {
        return $this->varsNames;
    }
}