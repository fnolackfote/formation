<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 03/03/2016
 * Time: 12:18
 */

namespace App\Frontend\Modules\News;

use \FormBuilder\CommentFormBuilder;
use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Entity\Comment;
use \OCFram\FormHandler;

class NewsController extends BackController
{
    public function executeIndex(HTTPRequest $request)
    {
        $number_of_news = $this->app->config()->get('nombre_news');
        $number_of_case_per_news = $this->app->config()->get('nombre_caracteres');

        $this->page->addVar('title', 'Liste des '.$number_of_news.' dernieres news');

        $manager = $this->managers->getManagerOf('News');

        $list_of_news = $manager->getNewscOrderByIdDesc_a(0, $number_of_news);

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
        $news = $this->managers->getManagerOf('News')->getUnique($request->getData('id'));

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

        if($request->method() == 'POST') {
            $comment = new Comment([
                //'news' => $request->getData('news'),
                'author' => $request->postData('author'),
                'content' => $request->postData('content')
            ]);
        }
        else {
            $comment = new Comment;
        }

        $formBuilder = new CommentFormBuilder($comment);
        $formBuilder->build();

        $form = $formBuilder->form();

        $formHandler = \OCFram\FormHandler($form, $this->managers->getManagerOf('Comments'), $request);

        if($formHandler->process())
        {
            $this->app->user()->setFlash('Le commentaire a bien été ajouté, merci !');
            $this->app->httpResponse()->redirect('news-'.$request->getData('news').'.html');
        }
        $this->page->addVar('comment', $comment);
        $this->page->addvar('form', $form->createview());
        $this->page->addVar('title', 'Ajout d\'un commentaire');
    }
}