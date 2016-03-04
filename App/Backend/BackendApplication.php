<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 03/03/2016
 * Time: 17:05
 */

namespace App\Backend;

use \OCFram\Application;

class BackendApplication extends Application
{
    public function __construct()
    {
        parent::__construct();
        $this->name = 'Backend';
    }

    public function run()
    {
        // TODO: Implement run() method.
        if($this->user->isAuthentificated())
        {
            $controller = $this->getController();
        }
        else
        {
            $controller = new Modules\Connexion\ConnexionController($this, 'Connexion', 'index');
        }

        $controller->execute();

        $this->httpResponse->setPage($controller->page());
        $this->httpResponse->send();
    }
}