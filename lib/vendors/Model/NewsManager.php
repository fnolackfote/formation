<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 03/03/2016
 * Time: 12:44
 */

namespace Model;


use \OCFram\Manager;
use \Entity\News;

abstract class NewsManager extends Manager
{
    /**
     * @Description Methode renvoyant la liste des $limite (5 par defaut) dernieres news postées.
     * @param $debut the LIMIT of the SELECT query si $debut = -1 LIMIT = 0
     * @param $limite the OFFSET of the SELECT query si $limite = -1 OFFSET = 5
     * @return an array
     */
    abstract public function getNewscOrderByIdDesc_a($debut = -1, $limite = -1);

    /**
     * @Description Methode renvoyant le nombre de News
     * @return int
     */
    abstract public function count();

    /**
     * Methode permettant d'ajouter une news
     * @param News $news la news que l'on veut ajouter
     * @return void
     */
    abstract protected function add(News $news);

    /**
     * Méthode êrmettant la modification d'une news
     * @param News $news La news a modifiée
     * @return void
     */
    abstract protected function modify(News $news);

    /**
     * Méthode permettant de supprimer une news
     * @param $id int Identifiant de la news à supprimer
     * @return void
     */
    abstract public function delete($id);

    /**
     * Methode permettant d'enregistrer une news
     * @param News $news La news a enregistrer
     * @see self::add()
     * @see self::modify()
     * @return void
     */
    public function save(News $news)
    {
        if($news->isValid())
        {
            $news->isNew() ? $this->add($news) : $this->modify($news);
        }
        else
        {
            throw new \RuntimeException('La news doit être validée pour être enregistrée');
        }
    }
}