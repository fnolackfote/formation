<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 16/03/2016
 * Time: 14:41
 */

namespace OCFram;

trait MainController
{
    public function createMenu()
    {
        if(!$this->app()->user()->isAuthenticated())
        {
            $menu = array('Inscription' => $this->app()->getHref('newAuthor','Frontend','Author'), 'Connexion' => $this->app()->getHref('logout','Backend','Connexion'));
        } else {
            $menu = array('Admin' => $this->app()->getHref('index','Backend','News'), 'Ajouter une news' => $this->app()->getHref('insert','Backend','News'), 'Deconnexion' => $this->app()->getHref('logout','Backend','Connexion'));
            if($this->app()->user()->rule() == \Entity\Author::RULE_ADMIN) {
                $menu_admin = array();
                $menu = array_merge($menu, $menu_admin);
            }
            // ########     Pareil pour les autres rule user       ####### //
        }
        $this->page()->addVar('menu', array_merge(array('Accueil' => $this->app()->getHref('index','Frontend','News')), $menu));
    }

    public function checkConnected()
    {
        return $this->app()->user()->isAuthenticated();
    }

    public function redirectUser()
    {
        if(!$this->checkConnected())
        {
            $this->app->user()->setFlash('Vous n\'ètes pas connecté');
            $this->app->httpResponse()->redirect($this->app->getHref('index','Frontend','News'));
        }
    }

    public function insertCookie()
    {

    }
}

