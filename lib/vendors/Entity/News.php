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
    protected $FNC_title,
              $FNC_content,
              $FNC_dateadd,
              $FNC_dateedit,
              $FNC_id,
              $FNC_fk_FAC;

    const AUTEUR_INVALIDE = 1;
    const TITRE_INVALIDE = 2;
    const CONTENU_INVALIDE = 3;

    public function isValid()
    {
        return !(empty($this->FNC_title) || empty($this->FNC_content));
    }

    //  SETTERS   //

    public function setFNC_title($title)
    {
        if(!is_string($title) || empty($title))
        {
            $this->erreurs[] = self::TITRE_INVALIDE;
        }

        $this->FNC_title = htmlentities(trim($title));
    }

    public function setFNC_content($content)
    {
        if(!is_string($content) || empty($content))
        {
            $this->erreurs[] = self::CONTENU_INVALIDE;
        }

        $this->FNC_content = htmlentities(trim($content));
    }

    public function setFNC_fk_FAC($author_id)
    {
        $this->FNC_fk_FAC = (int) $author_id;
    }

    public function setFNC_id($fnc_id)
    {
        $this->FNC_fk_FAC = (int) $fnc_id;
    }

    public function setFNC_dateadd(\DateTime $dateadd)
    {
        $this->FNC_dateadd = $dateadd;
    }

    public function setFNC_dateedit(\DateTime $dateedit)
    {
        $this->FNC_dateedit = $dateedit;
    }

    //   GETTERS   //
    public function FNC_content()
    {
        return html_entity_decode(trim($this->FNC_content));
    }

    public function FNC_fk_FAC()
    {
        return $this->FNC_fk_FAC;
    }

    public function FNC_dateadd()
    {
        return $this->FNC_dateadd;
    }

    public function FNC_title()
    {
        return html_entity_decode(trim($this->FNC_title));
    }

    public function FNC_id()
    {
        return $this->FNC_id;
    }

    public function FNC_dateedit()
    {
        return $this->FNC_dateedit;
    }
}