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
        $news_a = $manager->getNewscOrderByIdDesc_a();
        foreach($news_a as $news) {
            $userPostnews[$news->FNC_id()] = $this->managers->getManagerOf('Author')->getAuthorcUniqueByAuthorcId($news->FNC_fk_FAC());
        }

        $this->page->addVar('list_of_news', $news_a);
        $this->page->addVar('author', $userPostnews);
        $this->page->addVar('nombreNews', $manager->count());
    }

    /**
     * @param HTTPRequest $request
     */
    public function executeInsert(HTTPRequest $request)
    {
        $this->processForm($request);
        $this->page->addVar('title', 'Ajout d\'une news');
    }

    /**
     * @param HTTPRequest $request
     */
    public function executeUpdate(HTTPRequest $request)
    {
        $this->processForm($request);
        $this->page->addVar('title', 'Modification d\'une news');
    }

    /**
     * @param HTTPRequest $request
     */
    public function executeDelete(HTTPRequest $request)
    {
        $newsId = $request->getData('id');

        $this->managers->getManagerOf('News')->delete($newsId);
        $this->managers->getManagerOf('Comments')->deleteFromNews($newsId);

        $this->app->user()->setFlash('La news a bien été supprimée !');

        $this->app->httpResponse()->redirect('.');
    }

    /**
     * Methode pour cree le formulaire d'ajout
     * @param HTTPRequest $request
     */
    public function processForm(HTTPRequest $request)
    {

        if($request->method() == 'POST')
        {
            $news = new News([
                //'author' => $request->postData('author'),
                'FNC_title' => $request->postData('FNC_title'),
                'FNC_content' => $request->postData('FNC_content')
            ]);

            if($request->getExists('FNC_id'))
            {
                $news->setId($request->postData('FNC_id'));
            }
        }
        else{
            if($request->getExists('FNC_id'))
            {
                $news = $this->managers->getManagerOf('News')->getNewscUniqueUsingNewsId($request->getData('FNC_id'));
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

    /**
     * Methode pour Update un commentaire
     * @param HTTPRequest $request
     */
    public function executeUpdateComment(HTTPRequest $request)
    {
        $this->page->addVar('title', 'modification d\'un commentaire');
        $fcc_id = $request->getData('id');

        if($request->method() == 'POST') {
            $comment = new Comment([
                'FCC_id' => $fcc_id,
                'FCC_content' => $request->postData('FCC_content')
            ]);
        }
        else {
            $comment = $this->managers->getManagerOf('Comments')->get($fcc_id);
        }

        $formBuilder = new CommentFormBuilder($comment);
        $formBuilder->build();

        $form = $formBuilder->form();

        $formHandler = new FormHandler($form, $this->managers->getManagerOf('Comments'), $request);

        if($formHandler->process())
        {
            $this->app->user()->setFlash('Le commentaire a bien été modifié');
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