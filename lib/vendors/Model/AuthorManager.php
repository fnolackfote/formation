<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 08/03/2016
 * Time: 12:56
 */

namespace Model;

use \OCFram\Manager;
use \Entity\Author;

abstract class AuthorManager extends Manager
{
    /**
     * Méthode d'ajout d'un utilisateur en tant que auteur
     * @param Author $author L'auteur à ajouter
     * @return void
     */
    abstract protected function add(Author $author);

    /**
     * Méthode de modification de l'auteur
     * @param Author $author l'auteur à modifier
     * @return void
     */
    abstract protected function modify(Author $author);

    /**
     * Méthode permettant d'obtenir un auteur a partir de son identifiant
     * @param $id int Identifiant de l'auteur
     * @return Author
     * @othername getCommentcByCommentcId
     */
    abstract public function get($id);

    /**
     * Methode permettant de supprimer un auteur.
     * @param $id int Identifiant de l'auteur
     * @return void
     */
    abstract public function delete($id);

    /**
     * Méthode permettant de supprimer une news de l'auteur.
     * @param $news_id int Identifiant de la news
     * @return void
     */
    abstract public function deleteNewsOfAuthor($news_id);

    /**
     * Méthode permettant d'enregistrement un auteur
     * @param Author $author auteur a enregistrer
     * @return void
     * @othername insertIntoAuthorcOrModifyAuthorcc
     */
    public function save(Author $author)
    {
        if($author->isValid() && $author->isValidConnectify())
        //if(1)
        {
            $author->isNew() ? $this->add($author) : $this->modify($author);
        }
        else
        {
            throw new \RuntimeException('Les données saisie doivent etre valides.');
        }
    }

}