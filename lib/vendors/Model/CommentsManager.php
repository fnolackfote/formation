<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 03/03/2016
 * Time: 16:23
 */

namespace Model;

use \OCFram\Manager;
use \Entity\Comment;

abstract class CommentsManager extends Manager
{
    /**
     * Méthode d'ajout de commentaire
     * @param Comment $comment Le commentaire à ajouter
     * @return void
     */
    abstract protected function add(Comment $comment);

    /**
     * Méthode de modification ce commentaires
     * @param Comment $comment le commentaire à modifier
     * @return void
     */
    abstract protected function modify(Comment $comment);

    /**
     * Méthode permettant d'obtenir un commentaire a partir de son identifiant
     * @param $id int Identifiant du commentaire
     * @return Comment
     * @othername getCommentcByCommentcId
     */
    abstract public function get($id);

    /**
     * Methode permettant de supprimer un commentaire.
     * @param $id int Identifiant du commentaire
     * @return void
     */
    abstract public function delete($id);

    /**
     * Méthode permettant de supprimer tous les commentaires liés à une news.
     * @param $news_id int Identifiant de la news dont les commentaires doivent être supprimés
     * @return void
     */
    abstract public function deleteFromNews($news_id);

    /**
     * Méthode permettant d'enregistrement de commentaires
     * @param Comment $comment commentaire a enregistrer
     * @return void
     * @othername insertIntoCommentcOrModifyCommentc
     */
    public function save(Comment $comment)
    {
        if($comment->isValid())
        {
            $comment->isNew() ? $this->add($comment) : $this->modify($comment);
        }
        else
        {
            throw new \RuntimeException('Le commentaire doit être validé pour être enregistré.');
        }
    }

}