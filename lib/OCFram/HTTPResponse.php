<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 01/03/2016
 * Time: 17:16
 */

namespace OCFram;


class HTTPResponse extends ApplicationComponnent
{
    protected $page;

    public function addHeader($header)
    {
        header($header);
    }

    public function redirect($location)
    {
        header('Location: '.$location);
        exit;
    }

    public function redirect404()
    {
        //TODO
        $this->page = new Page($this->app, 'html');
        $this->page->setContentFile(__DIR__.'/../../Errors/404.html');

        $this->addHeader('HTTP/1.0 404 Not Found');

        $this->send();
    }

    public function send()
    {
        exit($this->page->getGeneratedPage());
    }

    public function setPage(Page $page)
    {
        $this->page = $page;
    }

    // Changement par rapport � la fonction setcookie() : le dernier argument est par d�faut � true
    public function setCookie($name, $value = '', $expire = 0, $path = null, $domain = null, $secure = false, $httpOnly = true)
    {
        setcookie($name, $value, $expire, $path, $domain, $secure, $httpOnly);
    }
}

?>