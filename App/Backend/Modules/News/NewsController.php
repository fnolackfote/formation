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
use \OCFRam\FormHandler;
use \FormBuilder\NewsFormBuilder;
use \FormBuilder\CommentFormBuilder;

class NewsController extends BackController
{
    /**
     * @param HTTPRequest $request
     */
    public function executeIndex(HTTPRequest $request)
    {
        $this->page->addVar('title', 'Gestion des news');

        $manager = $this->managers->getManagerOf('News');

        $this->page->addVar('list_of_news', $manager->getNewscOrderByIdDesc_a());
        $this->page->addVar('nombreNews', $manager->count());
    }

    public function executeInsert(HTTPRequest $request)
    {
        $this->processForm($request);
        $this->page->addVar('title', 'Ajout d\'une news');
    }

    public function executeUpdate(HTTPRequest $request)
    {
        $this->processForm($request);
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

        if($request->method() == 'POST')
        {
            $news = new News([
                'author' => $request->postData('author'),
                'title' => $request->postData('title'),
                'content' => $request->postData('content')
            ]);

            if($request->getExists('id'))
            {
                $news->setId($request->postData('id'));
            }
        }
        else{
            if($request->getExists('id'))
            {
                $news = $this->managers->getManagerOf('News')->getNewscUniqueUsingNewsId($request->getData('id'));
            }
            else{
                $news = new News;
            }
        }

        $formBuilder = new NewsFormBuilder($news);
        $formBuilder->build();

        $form = $formBuilder->form();

        $formHandler = new \OCFram\FormHandler($form, $this->managers->getManagerOf('News'), $request);


        if($formHandler->process())
        {
            $this->app->user()->setFlash($news->isNew() ? 'La news a bien été ajoutée !' : 'La news a bien été modifiée !');
            $this->app->httpResponse()->redirect('/admin/');
        }

        $this->page->addVar('form', $form->createView());
    }

    public function executeUpdateComment(HTTPRequest $request)
    {
        $this->page->addVar('title', 'modification d\'un commentaire');

        if($request->method() == 'POST') {
            $comment = new Comment([
                'id' => $request->getData('id'),
                'author' => $request->postData('author'),
                'content' => $request->postData('content')
            ]);
        }
        else {
            $comment = $this->managers->getManagerOf('Comments')->get($request->getData('id'));
        }

        $formBuilder = new CommentFormBuilder($comment);
        $formBuilder->build();

        $form = $formBuilder->form();

        $formHandler = new FormHandler($form, $this->managers->getManagerOf('Comments'), $request);

        if($formHandler->process())
        {
            $this->user()->setFlash('Le commentaire a bien été modifié');
            $this->app->httpResponse()->redirect('/admin/');
        }

        $this->page->addVar('form', $form->createView());
    }

    public function executeDeleteComment(HTTPRequest $request)
    {
        $this->managers->getManagerOf('Comments')->delete($request->getData('id'));
        $this->app->user()->setFlash('Le commentaire a bien été supprimé !');
        $this->app->httpResponse()->redirect('.');
    }

}