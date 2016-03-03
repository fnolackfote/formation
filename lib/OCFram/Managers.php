<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 01/03/2016
 * Time: 18:20
 */

namespace OCFram;


class Managers
{
    protected $api = null;
    protected $dao = null;
    protected $managers = [];

    public function __construct($api, $dao)
    {
        $this->api = $api;
        $this->dao = $dao;
    }

    public function getManagerOf($module)
    {
        if (!is_string($module) || empty($module))
        {
            throw new \InvalidArgumentException('Le module spécifié est invalide');
        }

        if (!isset($this->managers[$module]))
        {
            $manager = '\\Model\\'.$module.'Manager'.$this->api;

            $this->managers[$module] = new $manager($this->dao);
        }

        return $this->managers[$module];
    }
}