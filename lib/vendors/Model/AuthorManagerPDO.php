<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 08/03/2016
 * Time: 12:56
 */

namespace Model;

use \Entity\Author;
use \OCFram\Entity;

class AuthorManagerPDO extends AuthorManager
{
    /**
     * Méthode d'ajout d'un utilisateur en tant que auteur
     * @param Author $author L'auteur à ajouter
     * @return void
     */
    protected function add(Author $author)
    {
        $req = $this->dao->prepare('INSERT INTO t_frm_authorc SET FAC_firstname = :firstname, FAC_lastname = :lastname, FAC_email = :email, FAC_username = :username, FAC_password = :password');

        $req->bindValue(':firstname', $author->FAC_firstname());
        $req->bindValue(':lastname', $author->FAC_lastname());
        $req->bindValue(':email', $author->FAC_email());
        $req->bindValue(':username', $author->FAC_username());
        $req->bindValue(':password', $author->FAC_password());

        $req->execute();
    }

    /**
     * Obtenir Les infos du user connecte
     * @param $login
     * @param $pass
     * @return \Entity\Author
     */
    public function getConnexion($login, $pass)
    {
        $req = $this->dao->prepare('SELECT FAC_id, FAC_firstname, FAC_lastname, FAC_username, FAC_password, FAC_rule FROM t_frm_authorc WHERE FAC_username = :username AND FAC_password = :password');

        $req->bindValue(':username', $login);
        $req->bindValue(':password', $pass);

        $req->execute();

        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Author');

        if($authorConnected = $req->fetch())
        {
            return $authorConnected;
        }
        return null;
    }

    /**
     * @param $news_id
     * @return Author
     */
    public function getAuthorcByNewsId($news_id)
    {
        $selectSpecificUser = 'SELECT FAC_id, FAC_firstname, FAC_lastname, FAC_email, FAC_username FROM t_frm_authorc INNER JOIN t_frm_newsc ON FNC_fk_FAC = FAC_id AND FNC_id = '.$news_id.' ORDER BY FNC_id DESC';

        $selectUniqueSpecificUser = $this->dao->query($selectSpecificUser);

        $selectUniqueSpecificUser->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Author');

        $selectedUser = $selectUniqueSpecificUser->fetch();

        return $selectedUser;
    }

    /**
     * @param int $comment_id
     * @return \Entity\Author
     */
    public function getAuthorcByCommentId($comment_id)
    {
        $selectUniqueSpecificUser = $this->dao->prepare('SELECT FAC_id, FAC_firstname, FAC_lastname, FAC_email, FAC_username FROM t_frm_authorc INNER JOIN t_frm_commentc ON FCC_fk_FAC = FAC_id AND FCC_id = :id_comment AND FCC_email IS NULL ORDER BY FCC_id DESC');
        $selectUniqueSpecificUser->bindValue(':id_comment', $comment_id, \PDO::PARAM_INT);

        $selectUniqueSpecificUser->execute();

        $selectUniqueSpecificUser->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Author');

        $selectedUser = $selectUniqueSpecificUser->fetch();

        return $selectedUser;
    }

    public function getAuthorcUniqueByAuthorcId($user_id)
    {
        $selectSpecificUser = 'SELECT FAC_id, FAC_firstname, FAC_lastname, FAC_email, FAC_username, FAC_rule FROM t_frm_authorc WHERE FAC_id = '.$user_id;

        $selectUniqueSpecificUser = $this->dao->query($selectSpecificUser);

        $selectUniqueSpecificUser->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Author');

        $selectedUser = $selectUniqueSpecificUser->fetch();

        return $selectedUser;
    }

    /**
     * Obtenir l'identifiant du user connecter
     * @param $login username saisie
     * @param $pass password saisie
     * @return null
     */
    public function getIdUser($login, $pass)
    {
        $req = $this->dao->prepare('SELECT FAC_id FROM t_frm_authorc WHERE FAC_username = :username AND FAC_password = :password');

        $req->bindValue(':username', $login);
        $req->bindValue(':password', $pass);

        $req->execute();

        $req->setFetchMode(\PDO::FETCH_OBJ);

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