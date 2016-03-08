<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 08/03/2016
 * Time: 12:56
 */

namespace Model;

use \Entity\Author;

class AuthorManagerPDO extends AuthorManager
{
    /**
     * Méthode d'ajout d'un utilisateur en tant que auteur
     * @param Author $author L'auteur à ajouter
     * @return void
     */
    protected function add(Author $author)
    {
        // TODO: Implement add() method.
        $req = $this->dao->prepare('INSERT INTO t_frm_authorc SET FAC_firstname = :firstname, FAC_lastname = :lastname, FAC_username = :username, FAC_password = :password');

        $req->bindValue(':firstname', $author->FAC_firstname());
        $req->bindValue(':lastname', $author->FAC_lastname());
        $req->bindValue(':username', $author->FAC_username());
        $req->bindValue(':password', \sha1($author->FAC_password()));

        $req->execute();
    }

    public function getConnexion($login, $pass)
    {
        // TODO: Implement add() method.
        $req = $this->dao->prepare('SELECT FAC_firstname, FAC_lastname, FAC_username, FAC_password FROM t_frm_authorc WHERE FAC_username = :username AND FAC_password = :password');

        $req->bindValue(':username', $login);
        $req->bindValue(':password', crypt($pass));

        $req->execute();

        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Author');

        if($authorConnected = $req->fetch())
        {
            return $authorConnected;
        }

        return null;
    }

    /**
     * Méthode de modification de l'auteur
     * @param Author $author l'auteur à modifier
     * @return void
     */
    protected function modify(Author $author)
    {
        // TODO: Implement modify() method.
    }

    /**
     * Méthode permettant d'obtenir un auteur a partir de son identifiant
     * @param $id int Identifiant de l'auteur
     * @return Author
     * @othername getCommentcByCommentcId
     */
    public function get($id)
    {
        // TODO: Implement get() method.
    }

    /**
     * Methode permettant de supprimer un auteur.
     * @param $id int Identifiant de l'auteur
     * @return void
     */
    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    /**
     * Méthode permettant de supprimer une news de l'auteur.
     * @param $news_id int Identifiant de la news
     * @return void
     */
    public function deleteNewsOfAuthor($news_id)
    {
        // TODO: Implement deleteNewsOfAuthor() method.
    }
}