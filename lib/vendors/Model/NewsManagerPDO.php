<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 03/03/2016
 * Time: 12:50
 */

namespace Model;

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

    public function getNewscUniqueUsingNewsId($newsc_id)
    {
        $selectNewscUsingNewsid = $this->dao->prepare('SELECT FNC_id, FNC_title, FNC_content, FNC_dateadd, FNC_dateedit, FNC_fk_FAC FROM t_frm_newsc ORDER BY FNC_id = :news_id');
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

    public function count()
    {
        // TODO: Implement count() method.
        return $this->dao->query('SELECT COUNT(*) FROM t_frm_newsc')->fetchColumn();
    }

    protected function add(News $news)
    {
        $req = $this->dao->prepare('INSERT INTO t_frm_newsc SET FNC_author = :author, FNC_title = :title, FNC_content = :content, FNC_dateadd = NOW(), FNC_dateedit = NOW()');

        $req->bindValue(':author', $news->FNC_author());
        $req->bindValue(':title', $news->FNC_title());
        $req->bindValue(':content', $news->FNC_content());

        $req->execute();
    }

    protected function modify(News $news)
    {
        $req = $this->dao->prepare('UPDATE t_frm_newsc SET FNC_title = :title, FNC_content = :content, FNC_dateedit = NOW() WHERE FNC_id = :id');

        $req->bindValue(':title', $news->FNC_title());
        $req->bindValue(':content', $news->FNC_content());
        $req->bindValue(':id', $news->id(), \PDO::PARAM_INT);

        $req->execute();
    }

    public function delete($id)
    {
        $this->dao->exec('DELETE FROM t_frm_newsc WHERE FNC_id = '.(int) $id);
    }
}