<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 03/03/2016
 * Time: 11:19
 */
namespace Entity;

use \OCFram\Entity;


class News extends Entity
{

    /**
     * @vars
     *      varchar title (fnc_title) ==> titre du post
     *      text content (fnc_content) ==> contenu du post
     *      datetime dateadd (fnc_dateadd) ==> date d'ajout
     *      datetime dateedit (fnc_dateedit) ==> date de modif
     *      int author (fnc_fk_fac) ==> id de l'auteur du post
     */
    protected $title,
              $content,
              $dateadd,
              $dateedit,
              $author;

    const AUTEUR_INVALIDE = 1;
    const TITRE_INVALIDE = 2;
    const CONTENU_INVALIDE = 3;

    public function isValid()
    {
        return !(empty($this->author) || empty($this->title) || empty($this->content));
    }


    //  SETTERS   //

    public function setTitle($title)
    {
        if(!is_string($title) || empty($title))
        {
            $this->erreurs[] = self::TITRE_INVALIDE;
        }

        $this->title = $title;
    }

    public function setContent($content)
    {
        if(!is_string($content) || empty($content))
        {
            $this->erreurs[] = self::CONTENU_INVALIDE;
        }

        $this->content = $content;
    }

    public function setAuthor($author)
    {
        if(!is_string($author) || empty($author))
        {
            $this->erreurs[] = self::CONTENU_INVALIDE;
        }

        $this->author = $author;
    }

    public function setDateadd(\DateTime $dateadd)
    {
        $this->dateadd = $dateadd;
    }

    public function setDateedit(\DateTime $dateedit)
    {
        $this->dateedit = $dateedit;
    }

    //   GETTERS   //
    public function content()
    {
        return $this->content;
    }

    public function author()
    {
        return $this->author;
    }

    public function dateadd()
    {
        return $this->dateadd;
    }

    public function title()
    {
        return $this->title;
    }

    public function dateedit()
    {
        return $this->dateedit;
    }

}