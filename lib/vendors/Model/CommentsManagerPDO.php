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
    /**
     * @othername insertIntoCommentcOrModifyCommentc
     * @param int $user_id l'id du user connecter si personne n'est connecté, $user_id = null
     */
    protected function add(Comment $comment, $user_id = null)
    {
        $insertCommentc = $this->dao->prepare('INSERT INTO t_frm_commentc SET FCC_content = :content, FCC_date = NOW(), FCC_fk_FAC = :author, FCC_fk_FNC = :news, FCC_email = :email');

        $insertCommentc->bindValue(':content', $comment->FCC_content());
        $insertCommentc->bindValue(':author', !empty($user_id) ? (int) $user_id : 0, \PDO::PARAM_INT);
        $insertCommentc->bindValue(':news', $comment->FCC_fk_FNC(), \PDO::PARAM_INT);
        $insertCommentc->bindValue(':email', empty($user_id) ? $comment->FCC_email() : '');

        $insertCommentc->execute();

        $comment->setId($this->dao->lastInsertId());
    }

    /**
     * Ensemble des commentaire de l'auteur identifie par $author_id
     * @param int $author_id Identifiant de l'auteur
     * @return \Entity\Comment
     */
    public function getCommentcByUsingAuthorId($author_id)
    {
        if(!ctype_digit($author_id))
        {
            throw new \InvalidArgumentException('L\'identifiant de l\'auteur passé doit être un entier valide.');
        }

        $req = $this->dao->prepare('SELECT FCC_id, FCC_content, FCC_fk_FAC, FCC_date, FCC_fk_FNC, FCC_email FROM t_frm_commentc WHERE FCC_fk_FAC = :author_id ORDER BY FCC_date DESC');

        $req->bindValue(':author_id', $author_id, \PDO::PARAM_INT);

        $req->execute();

        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');
        //$req->setFetchMode(\PDO::FETCH_OBJ);

        $comments = $req->fetchAll();

        foreach ($comments as $comment)
        {
            $comment->setFCC_date(new \DateTime($comment->FCC_date(), new \DateTimeZone('Europe/Paris')));
        }

        return $comments;

    }

    /**
     * @param Comment $comment
     */
    protected function modify(Comment $comment)
    {
        $req = $this->dao->prepare('UPDATE comment SET content = :content WHERE id = :id');
        $req->bindValue(':content', $comment->content());
        $req->bindValue(':id', $comment->id());

        $req->execute();
    }

    /**
     * @othername getCommentcUniqueUsingCommentcId()
     * @param int $id
     * @return mixed
     */
    public function get($id)
    {
        $req = $this->dao->prepare('SELECT FCC_id, FCC_content, FCC_fk_FNC, FCC_email FROM t_frm_commentc WHERE FCC_id = :id GROUP BY FCC_fk_FNC');
        $req->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        $req->execute();

        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');

        $comments = $req->fetchAll();

        return $comments;
    }

    /**
     * @param int $id
     */
    public function delete($id)
    {
        $this->dao->execute('DELETE FROM t_frm_commentc WHERE FCC_id = '.(int) $id);
    }

    /**
     * @param int $news_id
     */
    public function deleteFromNews($news_id)
    {
        $this->dao->exec('DELETE FROM t_frm_commentc WHERE FCC_fk_FNC = '.(int) $news_id);
    }

    /**
     * @param int $news l'id de la news
     * @return mixed
     */
    public function getListOf($news_id)
    {
        if(!ctype_digit($news_id))
        {
            throw new \InvalidArgumentException('L\'identifiant de la news passé doit être un entier valide.');
        }

        // TODO : Requete a revoir. Divise en 2.
        $req = $this->dao->prepare('SELECT FCC_id, FCC_content, FCC_fk_FAC, FCC_date, FCC_fk_FNC, FCC_email FROM t_frm_commentc WHERE FCC_fk_FNC = :news ORDER BY FCC_date DESC');

        $req->bindValue(':news', $news_id, \PDO::PARAM_INT);

        $req->execute();

        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');
        //$req->setFetchMode(\PDO::FETCH_OBJ);

        $comments = $req->fetchAll();

        foreach ($comments as $comment)
        {
            $comment->setFCC_date(new \DateTime($comment->FCC_date(), new \DateTimeZone('Europe/Paris')));
        }

        return $comments;
    }
}