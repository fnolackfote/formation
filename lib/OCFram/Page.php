<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 02/03/2016
 * Time: 18:28
 */

namespace OCFram;

class Page extends ApplicationComponnent
{
    protected $contentFile;
    protected $format = 'html';
    protected $vars = [];

    public function __construct(Application $app, $format)
    {
        parent::__construct($app);

        $this->format = $format;
    }

    public function addVar($var, $value)
    {
        if(!is_string($var) || is_numeric($var) || empty($var))
        {
            throw new \InvalidArgumentException('Le nom de la variable doit être une chaine de caractères non nulle');
        }
        $this->vars[$var] = $value;
    }

    public function getGeneratedPage()
    {
        if(!file_exists($this->contentFile))
        {
            throw new \RuntimeException('La vue spécifiée n\'existe pas');
        }

        $user = $this->app->user();

        extract($this->vars);

        if($this->format == 'json') {
           //echo $this->contentFile;
            require $this->contentFile;
            return $json;
        }
            ob_start();
                require $this->contentFile;
            $content = ob_get_clean();

        ob_start();
            require __DIR__.'/../../App/'.$this->app->name().'/Templates/layout.php';
        return ob_get_clean();
    }

    public function setContentFile($contentFile)
    {
        if(!is_string($contentFile) || empty($contentFile))
        {
            throw new \InvalidArgumentException('La vue spécifiée est invalide');
        }
        $this->contentFile = $contentFile;
    }
}

?>