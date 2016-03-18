<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 03/03/2016
 * Time: 17:23
 */

namespace App\Backend\Modules\Connexion;

use \OCFram\MainController;
use \OCFram\BackController;
use \OCFram\HTTPRequest;

class ConnexionController extends BackController
{
    use MainController;

    public function executeIndex(HTTPRequest $request)
    {
        $this->createMenu();
        $this->page->addVar('title', 'Connexion');

        if($request->postExists('login'))
        {
            $login = $request->postData('login');
            $password = $request->postData('password');

            $connected = $this->managers->getManagerOf('Author')->getConnexion($login, $password);

            if(!is_null($connected))
            {
                $this->app->user()->setFlash('Connecte en tant que <b>'.$connected->FAC_username().'</b>');
                $this->app->user()->setSessionUser($connected->FAC_id());
                $this->app->user()->setAttribute('username', $connected->FAC_username());
                $this->app->user()->setAttribute('rule', $connected->FAC_rule());
                $this->app->user()->setRule($connected->FAC_rule());
                $this->app->user()->setAuthenticated(true);
                $this->app->httpResponse()->redirect($this->app->getHref('index','Backend','News'));
            }
            else
            {
                $this->app->user()->setFlash('Le pseudo ou le mot de passe est incorrect');
            }
        }
    }

    public function executeLogout()
    {
        $this->createMenu();
        //if($this->app->user()->isAuthenticated()) {
        $this->redirectUser();
        $this->page->addVar('title', 'Déconnexion');

        $this->app->user()->setAuthenticated(false);
        session_unset();
        session_destroy();
        session_start();
        $this->app->user()->setFlash('Deconnexion Reussie');

        $this->app->httpResponse()->redirect($this->app->getHref('index','Backend','News'));
        /*}
        else {
            $this->app->user()->setFlash('Vous n\'ètes pas connecté');
            $this->app->httpResponse()->redirect($this->app->getHref('index','Frontend','News'));
        }*/
    }
}