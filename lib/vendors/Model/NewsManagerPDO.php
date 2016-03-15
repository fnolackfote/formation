<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 03/03/2016
 * Time: 12:50
 */

namespace Model;

use Entity\Author;
use \Entity\News;

class NewsManagerPDO extends NewsManager
{
    const AUTHOR_ID = 1 ;

    /**
     * @equiv getList()
     * @param int $debut
     * @param int $limite
     * @return mixed
     */
    public function getNewscOrderByIdDesc_a($debut = -1, $limite = -1)
    {
        $selectNewscOrderByIdDesc = 'SELECT FNC_id, FNC_title, FNC_content, FNC_dateadd, FNC_dateedit, FNC_fk_FAC FROM t_frm_newsc ORDER BY FNC_id DESC';

        if($debut != -1 || $limite != -1)
        {
            $selectNewscOrderByIdDesc .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
        }

        $getSelectNewscOrderByIdDesc = $this->dao->query($selectNewscOrderByIdDesc);

        $getSelectNewscOrderByIdDesc->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\News');

        $list_of_news = $getSelectNewscOrderByIdDesc->fetchAll();

        foreach($list_of_news as $news)
        {
            $news->setFNC_dateadd(new \DateTime($news->FNC_dateadd(), new \DateTimeZone('Europe/Paris')));
            $news->setFNC_dateedit(new \DateTime($news->FNC_dateedit(), new \DateTimeZone('Europe/Paris')));
        }

        $getSelectNewscOrderByIdDesc->closeCursor();

        return $list_of_news;
    }

    /**
     * @param $newsc_id
     * @return null
     */
    public function getNewscUniqueUsingNewsId($newsc_id)
    {
        if(!ctype_digit($newsc_id))
        {
            throw new \InvalidArgumentException('La valeur passé doit être un entier valide.');
        }
        $selectNewscUsingNewsid = $this->dao->prepare('SELECT FNC_id, FNC_title, FNC_content, FNC_dateadd, FNC_dateedit, FNC_fk_FAC FROM t_frm_newsc WHERE FNC_id = :news_id ORDER BY FNC_id');
        $selectNewscUsingNewsid->bindValue('news_id', (int) $newsc_id, \PDO::PARAM_INT);
        $selectNewscUsingNewsid->execute();

        $selectNewscUsingNewsid->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\News');

        if($news = $selectNewscUsingNewsid->fetch())
        {
            $news->setFNC_dateadd(new \DateTime($news->FNC_dateadd(), new \DateTimeZone('Europe/Paris')));
            $news->setFNC_dateedit(new \DateTime($news->FNC_dateedit(), new \DateTimeZone('Europe/Paris')));

            return $news;
        }

        return null;
    }


    /**
     * Avoir la news par l'id du comment
     */
    public function getNewscIdUniqueUsingCommentId($comment_id)
    {
        if(!ctype_digit($comment_id))
        {
            throw new \InvalidArgumentException('La valeur passé doit être un entier valide.');
        }
        $selectNewscUsingNewsid = $this->dao->prepare('SELECT FNC_id FROM t_frm_newsc INNER JOIN t_frm_commentc ON FCC_fk_FNC = FNC_id AND FCC_id = :comment_id ORDER BY FNC_id');
        $selectNewscUsingNewsid->bindValue('comment_id', (int) $comment_id, \PDO::PARAM_INT);
        $selectNewscUsingNewsid->execute();

        $selectNewscUsingNewsid->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\News');

       return $selectNewscUsingNewsid->fetch();
    }

    /**
     * @return mixed
     */
    public function count()
    {
        return $this->dao->query('SELECT COUNT(*) FROM t_frm_newsc')->fetchColumn();
    }

    /**
     * @param News $news
     */
    protected function add(News $news)
    {
        $req = $this->dao->prepare('INSERT INTO t_frm_newsc SET FNC_fk_FAC = :author, FNC_title = :title, FNC_content = :content, FNC_dateadd = NOW(), FNC_dateedit = NOW()');

        $req->bindValue(':author', $_SESSION['user_id']);
        $req->bindValue(':title', $news->FNC_title());
        $req->bindValue(':content', $news->FNC_content());

        $req->execute();
    }

    /**
     * L'ensemble des news d'un Auteur identifier par author_id
     * @param int $author_id Identifiant de l'auteur
     * @return \Entity\News
     */
    public function getNewscByUsingAuthorId($author_id)
    {
        if(!ctype_digit($author_id))
        {
            throw new \InvalidArgumentException('L\'identifiant de l\'auteur passé doit être un entier valide.');
        }

        $selectNewscUsingNewsid = $this->dao->prepare('SELECT FNC_id, FNC_title, FNC_content, FNC_dateadd, FNC_dateedit, FNC_fk_FAC FROM t_frm_newsc ORDER BY FNC_fk_FAC = :author_id');

        $selectNewscUsingNewsid->bindValue('author_id', (int) $author_id, \PDO::PARAM_INT);
        $selectNewscUsingNewsid->execute();

        $selectNewscUsingNewsid->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\News');

        $newsByAuthorId_a = $selectNewscUsingNewsid->fetchAll();

        foreach($newsByAuthorId_a as $news)
        {
            $news->setFNC_dateadd(new \DateTime($news->FNC_dateadd(), new \DateTimeZone('Europe/Paris')));
            $news->setFNC_dateedit(new \DateTime($news->FNC_dateedit(), new \DateTimeZone('Europe/Paris')));
        }

        return $newsByAuthorId_a;
    }

    /**
     * @param News $news
     */
    protected function modify(News $news)
    {
        $req = $this->dao->prepare('UPDATE t_frm_newsc SET FNC_title = :title, FNC_content = :content, FNC_dateedit = NOW() WHERE FNC_id = :id');

        $req->bindValue(':title', $news->FNC_title());
        $req->bindValue(':content', $news->FNC_content());
        $req->bindValue(':id', $news->id(), \PDO::PARAM_INT);

        $req->execute();
    }

    /**
     * @param int $id
     */
    public function delete($id)
    {
        if(!ctype_digit($id))
        {
            throw new \InvalidArgumentException('La valeur passé doit être un entier valide.');
        }
        $this->dao->exec('DELETE FROM t_frm_newsc WHERE FNC_id = '.(int) $id);
    }
}