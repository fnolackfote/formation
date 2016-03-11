<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 03/03/2016
 * Time: 15:35
 */

namespace Entity;

use \OCFram\Entity;


class Comment extends Entity
{
    protected $FCC_content,
              $FCC_id,
              $FCC_date,
              $FCC_email,
                $FCC_username,
              $FCC_fk_FAC,
              $FCC_fk_FNC;

    const AUTEUR_INVALIDE = 1;
    const CONTENU_INVALIDE = 2;

    // TODO
    /**
     *
     * verifie si le contenu du comment est valide  ===> Non vide
     * @return bool
     */
    public function isValid()
    {
        return !empty($this->FCC_content);
    }

    public function setFCC_content($content)
    {
        if(!is_string($content) || empty($content))
        {
            $this->errors[] = self::CONTENU_INVALIDE;
        }

        $this->FCC_content = utf8_decode(trim($content));
    }

    public function setFCC_date(\DateTime $date)
    {
        $this->FCC_date = $date;
    }

    public function setFCC_fk_FNC($news_id)
    {
        $this->FCC_fk_FNC = (int) $news_id;
    }

    public function setFCC_fk_FAC($author_id)
    {
        $this->FCC_fk_FAC = (int) $author_id;
    }

    public function setFCC_email($email)
    {
        $this->FCC_email = utf8_decode(trim($email));
    }

    public function setFCC_id($id)
    {
        $this->FCC_id = (int) $id;
    }

    public function setFCC_username($username)
    {
        $this->FCC_username = utf8_decode(trim($username));
    }

    public function FCC_username()
    {
        return utf8_decode(trim($this->FCC_username));
    }

    public function FCC_id()
    {
        return $this->FCC_id;
    }

    public function FCC_email()
    {
        return utf8_decode(trim($this->FCC_email));
    }

    public function FCC_fk_FAC()
    {
        return $this->FCC_fk_FAC;
    }

    public function FCC_date()
    {
        return $this->FCC_date;
    }

    public function FCC_content()
    {
        return utf8_decode(trim($this->FCC_content));
    }

    public function FCC_fk_FNC()
    {
        return $this->FCC_fk_FNC;
    }
}