<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 03/03/2016
 * Time: 12:18
 */

namespace App\Frontend\Modules\News;

use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Entity\Comment;
use \OCFram\Form;
use OCFram\StringField;
use \OCFram\StringFilds;
use \Entity\TextField;

class NewsController extends BackController
{
    public function executeIndex(HTTPRequest $request)
    {
        $number_of_news = $this->app->config()->get('nombre_news');
        $number_of_case_per_news = $this->app->config()->get('nombre_caracteres');

        $this->page->addVar('title', 'Liste des '.$number_of_news.' dernieres news');

        $manager = $this->managers->getManagerOf('News');

        $list_of_news = $manager->getNewscOrderByIdDesc(0, $number_of_news);

        foreach ($list_of_news as $news)
        {
            if (strlen($news->content()) > $number_of_case_per_news)
            {
                $debut = substr($news->content(), 0, $number_of_case_per_news);
                $debut = substr($debut, 0, strrpos($debut, ' ')) . '...';

                $news->setContent($debut);
            }
        }

        $this->page->addVar('listeNews', $list_of_news);
    }

    public function executeShow(HTTPRequest $request)
    {
        $news = $this->managers->getManagerOf('News')->getUnique($request->getData('FNC_id'));

        if (empty($news))
        {
            $this->app->httpResponse()->redirect404();
        }

        $this->page->addVar('title', $news->title());
        $this->page->addVar('news', $news);
        $this->page->addVar('comments', $this->managers->getManagerOf('Comments')->getListOf($news->id()));
    }

    public function executeInsertComment(HTTPRequest $request)
    {
        $this->page->addVar('title', 'Ajout d\'un commentaire');

        if($request->postExists('pseudo')) {
            $comment = new Comment([
                //'news' => $request->getData('news'),
                'author' => $request->postData('pseudo'),
                'content' => $request->postData('content')
            ]);
        }
        else {
            $comment = new Comment;
        }

        $form = new Form($comment);

        $form->add(new StringField([
            'label' => 'Auteur',
            'name' => 'auteur',
            'maxlength' => 50
        ]))
            ->add(new StringField([
                'label' => 'Contenu',
                'name' => 'contenu',
                'rows' => 7,
                'cols' => 50
            ]));

        if($form->isValid())
        {

        }

        $this->page->addVar('comment', $comment);
        $this->page->addvar('form', $form->createview());
        $this->page->addVar('title', 'Ajout d\'un commentaire');

    }
}