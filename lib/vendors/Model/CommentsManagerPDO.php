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
        $insertCommentc = $this->dao->prepare('INSERT INTO t_frm_comment(FCC_content, FCC_date, FCC_fk_FAC, FCC_fk_FNC) SET FCC_content = :content, FCC_date = NOW(), FCC_fk_FAC = :FAC_id, FCC_fk_FNC = :FNC_id');

        $insertCommentc->bindValue(':content', $comment->content());
        $insertCommentc->bindValue(':FAC_id', FAC_ID, \PDO::PARAM_INT);
        $insertCommentc->bindValue(':FNC_id', FNC_ID, \PDO::PARAM_INT);

        $insertCommentc->execute();

        $comment->setId($this->dao->lastInsertId());
    }

    /**
     *
     */
    protected function modify(Comment $comment)
    {
        // TODO: Implement modify() method.
        $req = $this->dao->prepare('UPDATE t_frm_commentc SET FCC_content = :content WHERE FCC_id = :id');
        $req->bindValue(':content', $comment->content());
        $req->bindValue(':id', $comment->id());

        $req->execute();
    }

    public function get($id)
    {
        // TODO: Implement get() method.
        $req = $this->dao->prepare('SELECT FCC_id, FCC_content, FCC_fk_FAC, FCC_fk_FNC FROM t_frm_commentc WHERE FCC_id = :id');
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
}