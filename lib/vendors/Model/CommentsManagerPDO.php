<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 03/03/2016
 * Time: 16:28
 */

namespace Model;

use \Entity\Comment;

class CommentsManagerPDO extends CommentsManager
{
    const FAC_ID = 1;
    const FNC_ID = 1;

    /**
     * @othername insertIntoCommentcOrModifyCommentc
     */
    protected function add(Comment $comment)
    {
        // TODO: Implement add() method.
        $insertCommentc = $this->dao->prepare('INSERT INTO comment(content, date, author, news) SET content = :content, date = NOW(), author = :author, news = :news');

       /* $comment->setContent(empty(trim($comment->content())) ? 'test insert comment 01' : trim($comment->content()));
        $comment->setAuthor(empty(trim($comment->author())) ? 'test insert comment 01' : trim($comment->author())); */

        $insertCommentc->bindValue(':content', $comment->content());
        $insertCommentc->bindValue(':author', $comment->author());
        $insertCommentc->bindValue(':news', $comment->news(), \PDO::PARAM_INT);

        $insertCommentc->execute();

        $comment->setId($this->dao->lastInsertId());
    }

    /**
     *
     */
    protected function modify(Comment $comment)
    {
        // TODO: Implement modify() method.
        $req = $this->dao->prepare('UPDATE comment SET content = :content WHERE id = :id');
        $req->bindValue(':content', $comment->content());
        $req->bindValue(':id', $comment->id());

        $req->execute();
    }

    public function get($id)
    {
        // TODO: Implement get() method.
        $req = $this->dao->prepare('SELECT id, content, author, news FROM comment WHERE id = :id');
        $req->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        $req->execute();

        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');

        return $req->fetch();
    }

    public function delete($id)
    {
        $this->dao->exec('DELETE FROM comment WHERE id = '.(int) $id);
    }

    public function deleteFromNews($news_id)
    {
        // TODO: Implement deleteFromNews() method.
        $this->dao->exec('DELETE FROM comment WHERE news = '.(int) $news_id);
    }

    public function getListOf($news)
    {
        if(!ctype_digit($news))
        {
            throw new \InvalidArgumentException('L\'identifiant de la news passé doit être un entier valide.');
        }

        $req = $this->dao->prepare('SELECT id, content, author, date, news FROM comment WHERE news = :news');
        $req->bindValue(':news', $news, \PDO::PARAM_INT);

        $req->execute();

        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');

        $comments = $req->fetchAll();

        foreach($comments as $comment)
        {
            $comment->setDate(new \DateTime($comment->date(), new \DateTimeZone('Europe/Paris')));
        }

        return $comments;
    }
}