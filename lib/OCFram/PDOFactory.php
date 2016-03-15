<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 01/03/2016
 * Time: 18:21
 */

namespace OCFram;


class PDOFactory
{
    public static function getMysqlConnexion()
    {
        //$db = new \PDO('mysql:host=localhost;dbname=news_bdd', 'root', 'root');
        $db = new \PDO('mysql:host=localhost;dbname=bdd_frm_news', 'root', 'root');
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $db->query('SET NAMES UTF8');

        return $db;
    }

}