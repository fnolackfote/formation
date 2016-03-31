<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 01/03/2016
 * Time: 17:29
 */

namespace OCFram;


abstract class Application
{
    protected $httpRequest;
    protected $httpResponse;
    protected $name;
    protected $config;
    protected $user;

    public function __construct()
    {
        $this->httpRequest = new HTTPRequest($this);
        $this->httpResponse = new HTTPResponse($this);
        $this->config = new Config($this);
        $this->user = new User($this);

        $this->name = '';
    }

    //TODO A terminer.
    public function getHref($action, $name, $module,  $vars = array())
    {
        $router = new Router;

        $xml = new \DOMDocument;
        $xml->load(__DIR__.'/../../App/'.$name.'/Config/routes.xml');

        $routes = $xml->getElementsByTagName('route');

        foreach($routes as $route) {
            if($route->getAttribute('action') == $action & $route->getAttribute('module') == $module) {
                $url = $route->getAttribute('url');
                if ($route->hasAttribute('vars')) {
                    $vars = explode(',', $route->getAttribute('vars'));
                    $matchedRoute = $router->getRoute($this->httpRequest->requestURI());
                    $_GET = array_merge($_GET, $matchedRoute->vars());
//                    $search = '([0-9]+)';
//                    for($i=0; $i < count($vars); $i++)
//                        $url = str_replace($search, $vars[$i], $url);
                }
                // TODO
                $router->addRoute(new Route($url, $module, $action, $vars, 'html'));
                //var_dump($router->getRoute($url)->url());

                $search = '\\';
                $replace = '';
                return str_replace($search, $replace, $url);
            }
        }
    }

    public function getController()
    {
        $router = new Router;


        $xml = new \DOMDocument;
        $xml->load(__DIR__.'/../../App/'.$this->name.'/Config/routes.xml');

        $routes = $xml->getElementsByTagName('route');

        // On parcourt les routes du fichier XML.
        foreach ($routes as $route)
        {
            $vars = [];

            // On regarde si des variables sont pr�sentes dans l'URL.
            if ($route->hasAttribute('vars'))
            {
                $vars = explode(',', $route->getAttribute('vars'));
            }
            $format = $route->hasAttribute('outfile') ? $route->getAttribute('outfile') : 'html';

            // On ajoute la route au routeur.
            $router->addRoute(new Route($route->getAttribute('url'), $route->getAttribute('module'), $route->getAttribute('action'), $vars, $format));
        }

        try
        {
            // On r�cup�re la route correspondante � l'URL.
            $matchedRoute = $router->getRoute($this->httpRequest->requestURI());
        }
        catch (\RuntimeException $e)
        {
            if ($e->getCode() == Router::NO_ROUTE)
            {
                // Si aucune route ne correspond, c'est que la page demand�e n'existe pas.
                $this->httpResponse->redirect404();
            }
        }

        // On ajoute les variables de l'URL au tableau $_GET.
        $_GET = array_merge($_GET, $matchedRoute->vars());

        // On instancie le controleur.      App\Backend\Modules\News\NewsController
        $controllerClass = 'App\\'.$this->name.'\\Modules\\'.$matchedRoute->module().'\\'.$matchedRoute->module().'Controller';
        return new $controllerClass($this, $matchedRoute->module(), $matchedRoute->action(), $matchedRoute->format());       // App\Backend\Modules\News\NewsController(BackendApplication, News, insert)
    }

    abstract public function run();

    public function httpRequest()
    {
        return $this->httpRequest;
    }

    public function httpResponse()
    {
        return $this->httpResponse;
    }

    public function name()
    {
        return $this->name;
    }

    public function config()
    {
        return $this->config;
    }

    public function user()
    {
        return $this->user;
    }
}