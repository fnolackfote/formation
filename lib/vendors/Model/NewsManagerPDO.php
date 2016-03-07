<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 03/03/2016
 * Time: 12:50
 */

namespace Model;

use \Entity\News;

class NewsManagerPDO extends  NewsManager
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
        $selectNewscOrderByIdDesc = 'SELECT id, title, content, dateadd, dateedit, author FROM news ORDER BY id DESC';

        if($debut != -1 || $limite != -1)
        {
            $selectNewscOrderByIdDesc .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
        }

        $getSelectNewscOrderByIdDesc = $this->dao->query($selectNewscOrderByIdDesc);

        $getSelectNewscOrderByIdDesc->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\News');

        $list_of_news = $getSelectNewscOrderByIdDesc->fetchAll();

        foreach($list_of_news as $news)
        {
            $news->setDateadd(new \DateTime($news->dateadd(), new \DateTimeZone('Europe/Paris')));
            $news->setDateedit(new \DateTime($news->dateedit(), new \DateTimeZone('Europe/Paris')));
        }

        $getSelectNewscOrderByIdDesc->closeCursor();

        return $list_of_news;
    }

    public function getNewscUniqueUsingNewsId($newsc_id)
    {
        $selectNewscUsingNewsid = $this->dao->prepare('SELECT id, title, content, dateadd, dateedit, author FROM news ORDER BY id = :news_id');
        $selectNewscUsingNewsid->bindValue('news_id', (int) $newsc_id, \PDO::PARAM_INT);
        $selectNewscUsingNewsid->execute();

        $selectNewscUsingNewsid->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\News');

        if($news = $selectNewscUsingNewsid->fetch())
        {
            $news->setDateadd(new \DateTime($news->dateadd(), new \DateTimeZone('Europe/Paris')));
            $news->setDateedit(new \DateTime($news->dateedit(), new \DateTimeZone('Europe/Paris')));

            return $news;
        }

        return null;
    }

    public function count()
    {
        // TODO: Implement count() method.
        return $this->dao->query('SELECT COUNT(*) FROM news')->fetchColumn();
    }

    protected function add(News $news)
    {
        $req = $this->dao->prepare('INSERT INTO news SET author = :author, title = :title, content = :content, dateadd = NOW(), dateedit = NOW()');

        $req->bindValue(':author', $news->author());
        $req->bindValue(':title', $news->title());
        $req->bindValue(':content', $news->content());

        $req->execute();
    }

    protected function modify(News $news)
    {
        $req = $this->dao->prepare('UPDATE news SET title = :title, content = :content, dateedit = NOW() WHERE id = :id');

        $req->bindValue(':title', $news->title());
        $req->bindValue(':content', $news->content());
        $req->bindValue(':id', $news->id(), \PDO::PARAM_INT);

        $req->execute();
    }

    public function delete($id)
    {
        $this->dao->exec('DELETE FROM news WHERE id = '.(int) $id);
    }
}