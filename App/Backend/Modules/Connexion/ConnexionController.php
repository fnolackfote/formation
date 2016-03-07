<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 03/03/2016
 * Time: 17:23
 */

namespace App\Backend\Modules\Connexion;


use \OCFram\BackController;
use \OCFram\HTTPRequest;

class ConnexionController extends BackController
{
    public function executeIndex(HTTPRequest $request)
    {
        $this->page->addVar('title', 'Connexion');

        if($request->postExists('login'))
        {
            $login = $request->postData('login');
            $password = $request->postData('password');

            if($login == $this->app->config()->get('login') && $password == $this->app->config()->get('pass'))
            {
                $this->app->user()->setAuthenticated(true);
                $this->app->httpResponse()->redirect('.');
            }
            else
            {
                $this->app->user()->setFlash('Le pseudo ou le mot de passe est incorrect');
            }
        }
    }

    public function executeLogout()
    {
        $this->page->addVar('title', 'Connexion');

        $this->app->user()->setAuthenticated(false);
        unset($_SESSION['auth']);
        $this->app->httpResponse()->redirect('/admin/');
    }

}