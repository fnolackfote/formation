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
    protected function add(Comment $comment)
    {
        $insertCommentc = $this->dao->prepare('INSERT INTO t_frm_commentc SET FCC_content = :content, FCC_date = NOW(), FCC_fk_FAC = :author, FCC_username = :username, FCC_fk_FNC = :news, FCC_email = :email');

        $insertCommentc->bindValue(':content', $comment->FCC_content());
        $insertCommentc->bindValue(':author', !empty($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : 0, \PDO::PARAM_INT);
        $insertCommentc->bindValue(':news', $comment->FCC_fk_FNC(), \PDO::PARAM_INT);
        $insertCommentc->bindValue(':email', empty($_SESSION['user_id']) ? (empty($comment->FCC_email()) ? '' : $comment->FCC_email()) : '');
        $insertCommentc->bindValue(':username', empty($_SESSION['user_id']) ? $comment->FCC_username() : '');

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

        $req = $this->dao->prepare('SELECT FCC_id, FCC_content, FCC_fk_FAC, FCC_date, FCC_fk_FNC, FCC_email, FCC_username FROM t_frm_commentc WHERE FCC_fk_FAC = :author_id ORDER BY FCC_date DESC');

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
        $req = $this->dao->prepare('UPDATE t_frm_commentc SET FCC_content = :content WHERE FCC_id = :id');
        $req->bindValue(':content', $comment->FCC_content());
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
        if(!ctype_digit($id))
        {
            throw new \InvalidArgumentException('La valeur passé doit être un entier valide.');
        }
        $req = $this->dao->prepare('SELECT FCC_id, FCC_content, FCC_fk_FNC, FCC_email, FCC_username, FCC_fk_FAC FROM t_frm_commentc WHERE FCC_id = :id GROUP BY FCC_fk_FNC');
        $req->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        $req->execute();

        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');

        return $req->fetch();
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
        $this->dao->exec('DELETE FROM t_frm_commentc WHERE FCC_id = '.(int) $id);
    }

    /**
     * @param int $news_id
     */
    public function deleteFromNews($news_id)
    {
        if(!ctype_digit($news_id))
        {
            throw new \InvalidArgumentException('La valeur passé doit être un entier valide.');
        }
        $this->dao->exec('DELETE FROM t_frm_commentc WHERE FCC_fk_FNC = '.(int) $news_id);
    }

    /**
     * @param int $news l'id de la news
     * @return mixed
     */
    public function getListOf($news_id, $limit = -1, $id = -1)
    {
        if(!ctype_digit($news_id))
        {
            throw new \InvalidArgumentException('L\'identifiant de la news passé doit être un entier valide.');
        }

        $query = 'SELECT FCC_id, FCC_content, FCC_fk_FAC, FCC_date, FCC_fk_FNC, FCC_email, FCC_username FROM t_frm_commentc WHERE';

        if($id != -1)
        {
            $query .= ' FCC_id < :id AND';
        }
        $query .= ' FCC_fk_FNC = :news  ORDER BY FCC_date DESC';

        if($limit != -1)
        {
            $query .= ' LIMIT '.(int)$limit;
        }

        $req = $this->dao->prepare($query);
        if($id != -1)
        {
            $req->bindValue(':id', $id, \PDO::PARAM_INT);
        }
        $req->bindValue(':news', $news_id, \PDO::PARAM_INT);

        $req->execute();

        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');

        $comments = $req->fetchAll();

        foreach ($comments as $comment)
        {
            $comment->setFCC_date(new \DateTime($comment->FCC_date(), new \DateTimeZone('Europe/Paris')));
        }

        return $comments;
    }

    public function getListOfComment_a($news_id, $limit = -1, $id = -1)
    {
        if(!ctype_digit($news_id))
        {
            throw new \InvalidArgumentException('L\'identifiant de la news passé doit être un entier valide.');
        }

        $query = 'SELECT FCC_id, FCC_content, FCC_fk_FAC, FCC_date, FCC_fk_FNC, FCC_email, FCC_username FROM t_frm_commentc WHERE';

        if($id != -1)
        {
            $query .= ' FCC_id < :id AND';
        }
        $query .= ' FCC_fk_FNC = :news  ORDER BY FCC_date DESC';

        if($limit != -1)
        {
            $query .= ' LIMIT '.(int)$limit;
        }

        $req = $this->dao->prepare($query);
        if($id != -1)
        {
            $req->bindValue(':id', $id, \PDO::PARAM_INT);
        }
        $req->bindValue(':news', $news_id, \PDO::PARAM_INT);

        $req->execute();

        $req->setFetchMode(\PDO::FETCH_ASSOC);

        return $req->fetchAll();
    }

    /**
     * @param int $news l'id de la news
     * @return mixed
     */
    public function getCommentcByUsingNewscIdExceptAuthorcId($news_id, $author_id)
    {
        if(!ctype_digit($news_id))
        {
            throw new \InvalidArgumentException('L\'identifiant de la news passé doit être un entier valide.');
        }

        $requete = 'SELECT FCC_id, FCC_email, FCC_fk_FNC, FCC_fk_FAC, FCC_username FROM t_frm_commentc INNER JOIN t_frm_authorc ON FCC_fk_FAC = FAC_id  AND FCC_fk_FNC = :id_news';
        if(!empty($author_id))
        {
            $requete .= ' AND FAC_id <> :id_author';
        }

        $requete .= ' GROUP BY FCC_fk_FAC, FCC_fk_FNC ORDER BY FCC_id DESC';


        $req = $this->dao->prepare($requete);
        $req->bindValue(':id_author', $author_id, \PDO::PARAM_INT);

        if(!empty($author_id)) {
            $req->bindValue(':id_news', $news_id, \PDO::PARAM_INT);
        }

        $req->execute();

        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');

        return $req->fetchAll();
    }
}