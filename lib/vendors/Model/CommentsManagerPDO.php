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
        $insertCommentc = $this->dao->prepare('INSERT INTO t_frm_commentc(FCC_content, FCC_date, FCC_author, FCC_fk_FNC, FCC_fk_FAC) SET FCC_content = :content, FCC_date = NOW(), FCC_fk_FAC = :author, FCC_fk_FNC = :news');

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
        $req = $this->dao->prepare('SELECT FCC_id, FCC_content, FCC_fk_FNC FROM t_frm_commentc WHERE FCC_id = :id GROUP BY FCC_fk_FNC');
        $req->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        $req->execute();

        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');

        return $req->fetch();
    }

    public function delete($id)
    {
        $this->dao->exec('DELETE FROM t_frm_commentc WHERE FCC_id = '.(int) $id);
    }

    public function deleteFromNews($news_id)
    {
        // TODO: Implement deleteFromNews() method.
        $this->dao->exec('DELETE FROM t_frm_commentc WHERE FCC_fk_FNC = '.(int) $news_id);
    }

    public function getListOf($news)
    {
        if(!ctype_digit($news))
        {
            throw new \InvalidArgumentException('L\'identifiant de la news passé doit être un entier valide.');
        }

        $req = $this->dao->prepare('SELECT FCC_id, FCC_content, FCC_fk_FAC, FCC_date, FCC_fk_FNC FROM t_frm_commentc WHERE FCC_fk_FNC = :news');
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