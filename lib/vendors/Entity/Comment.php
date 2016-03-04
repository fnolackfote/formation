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
    protected $content,
              $date,
              $author,
              $news;

    const AUTEUR_INVALIDE = 1;
    const CONTENU_INVALIDE = 2;

    public function isValid()
    {
        return !(empty($this->author) || empty($this->content));
    }

    public function setContent($content)
    {
        if(!is_string($content) || empty($content))
        {
            $this->errors[] = self::AUTEUR_INVALIDE;
        }

        $this->content = $content;
    }

    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    public function setNews($news)
    {
        $this->news = (int) $news;
    }

    public function setAuthor($author)
    {
        $this->author = (int) $author;
    }


    public function author()
    {
        return $this->author;
    }

    public function date()
    {
        return $this->date;
    }

    public function content()
    {
        return $this->content;
    }

    public function news()
    {
        return $this->news;
    }

}