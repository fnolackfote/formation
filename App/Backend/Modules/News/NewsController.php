<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 03/03/2016
 * Time: 17:33
 */

namespace App\Backend\Modules\News;


use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \OCFram\Comment;
use \Entity\News;

class NewsController extends BackController
{
    /**
     * @param HTTPRequest $request
     */
    public function executeIndex(HTTPRequest $request)
    {
        $this->page->addVar('title', 'Gestion des news');

        $manager = $this->managers->getManagerOf('News');

        $this->page->addVar('listnews', $manager->getNewscOrderByIdDesc_a());
        $this->page->addVar('nombreNews', $manager->count());
    }

    public function executeInsert(HTTPRequest $request)
    {
        if($request->postExists("author"))
        {
            $this->processForm($request);
        }

        $this->page->addVar('title', 'Ajout d\'une news');
    }

    public function executeUpdate(HTTPRequest $request)
    {
        if($request->postExists("author"))
        {
            $this->processForm($request);
        }

        $this->page->addVar('title', 'Modification d\'une news');
    }

    public function executeDelete(HTTPRequest $request)
    {
        $newsId = $request->getData('id');

        $this->managers->getManagerOf('News')->delete($newsId);
        $this->managers->getManagerOf('Comments')->deleteFromNews($newsId);

        $this->app->user()->setFlash('La news a bien été supprimée !');

        $this->app->httpResponse()->redirect('.');
    }

    public function processForm(HTTPRequest $request)
    {
        $news = new News([
            'author' => $request->postData('author'),
            'title' => $request->postData('title'),
            'content' => $request->postData('content')
        ]);

        if($request->postExists('id'))
        {
            $news->setId($request->postData('id'));
        }

        if($news->isValid())
        {
            $this->managers->getManagerOf('News')->save($news);

            $this->app->user()->setFlash($news->isNew() ? 'La news a bien été ajouté !' : 'La news a bein été modifiée !');
        }
        else
        {
            $this->page->addVar('erreurs', $news->erreurs());
        }

        $this->page->addVar('news', $news);
    }

    public function executeUpdateComment(HTTPRequest $request)
    {
        $this->page->addVar('title', 'modification d\'un commentaire');

        if($request->postExists('pseudo'))
        {
            $comment = new Comment([
                'id' => $request-getData('id'),
                'author' => $request->getData('author'),
                'content' => $request->getData('content')
            ]);

            if($comment->isValid())
            {
                $this->managers->getManagerOf('comments')->save($comment);
                $this->app->user()->setFlash('Le commentaire a bien été modifié !');
                $this->app->httpResponse()->redirect('/news-', $request->postData('news').'.html');
            }
            else
            {
                $this->page->addVar('erreurs', $comment->erreurs());
            }

            $this->page->addVar('comment', $comment);
        }
        else
        {
            $this->page->addVar('comment', $this->managers->getManagerOf('Comments')->get($request->getData('id')));
        }
    }

    public function executeDeleteComment(HTTPRequest $request)
    {
        $this->managers->getManagerOf('Comments')->delete($request->getData('id'));
        $this->app->user()->setFlash('Lecommentaire a bien été supprimé !');
        $this->app->httpResponse()->redirect('.');
    }

}