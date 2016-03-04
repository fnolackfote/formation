<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 03/03/2016
 * Time: 12:50
 */

namespace Model;

use \OCFram\Manager;

class NewsManagerPDO extends  NewsManager
{
    /**
     * @equiv getList()
     * @param int $debut
     * @param int $limite
     * @return mixed
     */

    const AUTHOR_ID = 1 ;

    public function getNewscOrderByIdDesc_a($debut = -1, $limite = -1)
    {
        $selectNewscOrderByIdDesc = 'SELECT FNC_id, FNC_title, FNC_content, FNC_dateadd, FNC_dateedit, FNC_fk_FAC FROM t_frm_news ORDER BY FNC_id DESC';

        if($debut != -1 || $limite != -1)
        {
            $selectNewscOrderByIdDesc .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
        }

        $getSelectNewscOrderByIdDesc = $this->dao->query($selectNewscOrderByIdDesc);
        $getSelectNewscOrderByIdDesc->setFetchMode(\PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, '\Entity\News');

        $list_of_news = $getSelectNewscOrderByIdDesc->fetchAll();

        foreach($list_of_news as $news)
        {
            $news->setDateadd(new \DateTime($news->dateadd()));
            $news->setDateedit(new \DateTime($news->dateedit()));
        }

        $getSelectNewscOrderByIdDesc->closeCursor();

        return $list_of_news;
    }

    public function getNewscUniqueUsingNewsId($newsc_id)
    {
        $selectNewscUsingNewsid = $this->dao->prepare('SELECT FNC_id, FNC_title, FNC_content, FNC_dateadd, FNC_dateedit, FNC_fk_FAC FROM t_frm_news WHERE FNC_id = :news_id');
        $selectNewscUsingNewsid->bindValue('news_id', (int)$newsc_id, \PDO::PARAM_INT);
        $selectNewscUsingNewsid->execute();

        $selectNewscUsingNewsid->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\News');

        if($news = $selectNewscUsingNewsid->fetch())
        {
            $news->setDateadd(new \DateTime($news->dateadd()));
            $news->setDateedit(new \DateTime($news->dateedit()));

            return $news;
        }

        return null;
    }

    public function count()
    {
        // TODO: Implement count() method.
        return $this->dao->query('SELECT COUNT(*) FROM t_frm_news')->fetchColumn();
    }

    protected function add(News $news)
    {
        $req = $this->dao->prepare('INSERT INTO t_frm_news SET FNC_fk_FAC = :author_id, FNC_title = :title, FNC_content = :content, FNC_dateadd = NOW(), FNC_dateedit = NOW()');

        $req->bindValue(':author_id', AUTHOR_ID, \PDO::PARAM_INT);
        $req->bindValue(':title', $news->title());
        $req->bindValue(':content', $news->content());

        $req->execute();
    }

    protected function modify(News $news)
    {
        $req = $this->dao->prepare('UPDATE t_frm_news SET FNC_title = :title, FNC_content = :content, FNC_dateedit = NOW() WHERE FNC_id = :id');

        $req->bindValue(':title', $news->title());
        $req->bindValue(':content', $news->content());
        $req->bindValue(':id', $news->id(), \PDO::PARAM_INT);

        $req->execute();
    }

    public function delete($id)
    {
        $this->dao->exec('DELETE FROM t_frm_news WHERE FNC_id = '.(int) $id);
    }
}