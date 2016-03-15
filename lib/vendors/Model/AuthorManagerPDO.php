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
        $req->bindValue(':password', crypt($author->FAC_password(), \Entity\Author::SALT));

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
        //$req->bindValue(':password', crypt($pass, \Entity\Author::SALT));

        $req->execute();

        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Author');

        if($authorConnected = $req->fetch())
        {
            return $authorConnected;
        }
        return null;
    }

    public function getConnexion2()
    {
        $req = $this->dao->prepare('SELECT FAC_firstname, FAC_lastname, FAC_username, FAC_password, FAC_rule FROM t_frm_authorc WHERE FAC_id <= 5');

        $req->execute();

        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Author');
        $author_a = $req->fetch();
        foreach($author_a as $author)
        {
            $req = $this->dao->exec('UPDATE t_frm_authorc SET FAC_password = '.crypt($author->FAC_password(), \Entity\Author::SALT));
        }

        /*UPDATE t_frm_authorc
            SET FAC_password = A.password
        FROM t_frm_authorc INNER JOIN (SELECT FAC_id id, FAC_password password FROM t_frm_authorc WHERE FAC_id <= 5) A
        ON A.id = FAC_id*/
    }

    /**
     * @param $news_id
     * @return Author
     */
    public function getAuthorcByNewsId($news_id)
    {
        if(!ctype_digit($news_id))
        {
            throw new \InvalidArgumentException('La valeur passé doit être un entier valide.');
        }
        $selectSpecificUser = 'SELECT FAC_id, FAC_firstname, FAC_lastname, FAC_email, FAC_username FROM t_frm_authorc INNER JOIN t_frm_newsc ON FNC_fk_FAC = FAC_id AND FNC_id = '.$news_id.' ORDER BY FNC_id DESC';

        $selectUniqueSpecificUser = $this->dao->query($selectSpecificUser);

        $selectUniqueSpecificUser->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Author');

        return $selectUniqueSpecificUser->fetch();
    }

    /**
     * @param int $comment_id
     * @return \Entity\Author
     */
    public function getAuthorcByCommentId($comment_id)
    {
        if(!ctype_digit($comment_id))
        {
            throw new \InvalidArgumentException('La valeur passé doit être un entier valide.');
        }
        $selectUniqueSpecificUser = $this->dao->prepare('SELECT FAC_id, FAC_firstname, FAC_lastname, FAC_email, FAC_username FROM t_frm_authorc INNER JOIN t_frm_commentc ON FCC_fk_FAC = FAC_id AND FCC_id = :id_comment AND FCC_username IS NULL ORDER BY FCC_id DESC');
        $selectUniqueSpecificUser->bindValue(':id_comment', $comment_id, \PDO::PARAM_INT);

        $selectUniqueSpecificUser->execute();

        $selectUniqueSpecificUser->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Author');

        return $selectUniqueSpecificUser->fetch();
    }

    public function getAuthorcUniqueByAuthorcId($user_id)
    {
        if(!ctype_digit($user_id))
        {
            throw new \InvalidArgumentException('La valeur passé doit être un entier valide.');
        }
        $selectSpecificUser = 'SELECT FAC_id, FAC_firstname, FAC_lastname, FAC_email, FAC_username, FAC_rule FROM t_frm_authorc WHERE FAC_id = '.$user_id;

        $selectUniqueSpecificUser = $this->dao->query($selectSpecificUser);

        $selectUniqueSpecificUser->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Author');

        return $selectUniqueSpecificUser->fetch();
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