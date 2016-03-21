<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 03/03/2016
 * Time: 17:33
 */

namespace App\Backend\Modules\News;

use \OCFram\MainController;
use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Entity\Comment;
use \Entity\News;
use \OCFram\FormHandler;
use \FormBuilder\NewsFormBuilder;
use \FormBuilder\CommentFormBuilder;

class NewsController extends BackController
{
    use MainController;

    /**
     * @param HTTPRequest $request
     */
    public function executeIndex(HTTPRequest $request)
    {
        $this->createMenu();
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
        $this->createMenu();
        //if($this->app->user()->isAuthenticated()) {
        $this->redirectUser();
        $this->processForm($request);
        $this->page->addVar('title', 'Ajout d\'une news');
        /*}
        else {
            $this->app->user()->setFlash('Vous n\'etes pas authentifié pour effectuer cette action..');
            //$this->app->httpResponse()->redirect('.');
            $this->app->httpResponse()->redirect($this->app->getHref('index','Frontend','News'));
        }*/
    }

    /**
     * @param HTTPRequest $request
     */
    public function executeUpdate(HTTPRequest $request)
    {
        $this->createMenu();
        //if($this->app->user()->isAuthenticated()) {
        $this->redirectUser();
        $this->processForm($request);
        $this->page->addVar('title', 'Modification d\'une news');
        /*}
        else {
            $this->app->user()->setFlash('Vous n\'etes pas authentifié pour effectuer cette action..');
            //$this->app->httpResponse()->redirect('.');
            $this->app->httpResponse()->redirect($this->app->getHref('index','Frontend','News'));
        }*/
    }

    /**
     * Supprimer une news
     * @param HTTPRequest $request
     */
    public function executeDelete(HTTPRequest $request)
    {
        $this->createMenu();
        if($request->getExists('news_id')) {
            $newsId = $request->getData('news_id');
        }

        $news = $this->managers->getManagerOf('News')->getNewscUniqueUsingNewsId($newsId);
        $this->redirectUser();
        //if($this->app->user()->isAuthenticated() && ($this->app->user()->rule() == \Entity\Author::RULE_ADMIN | $this->app->user()->sessionUser() == (int) $news->FNC_fk_FAC())) {
        if($this->app->user()->rule() == \Entity\Author::RULE_ADMIN | $this->app->user()->sessionUser() == (int) $news->FNC_fk_FAC()) {
            $this->managers->getManagerOf('News')->delete($newsId);
            $this->managers->getManagerOf('Comments')->deleteFromNews($newsId);

            $this->app->user()->setFlash('La news a bien été supprimée !');

            $this->app->httpResponse()->redirect($this->app->getHref('index','Backend', 'News'));
        }
        /*else {
            $this->app->user()->setFlash('Vous n\'avez pas les droits pour supprimer cette news !');
            $this->app->httpResponse()->redirect($this->app->getHref('index','Frontend', 'News'));
            //$this->app->httpResponse()->redirect($this->app->getHref('index','Frontend', 'News'));
        }*/
    }

    /**
     * Methode pour cree le formulaire d'ajout
     * @param HTTPRequest $request
     */
    public function processForm(HTTPRequest $request)
    {
        if ($request->method() == 'POST')
        {
            $news = new News([
                'FNC_title' => $request->postData('FNC_title'),
                'FNC_fk_FAC' => $this->app->user()->sessionUser(),
                'FNC_content' => $request->postData('FNC_content')
            ]);

            if ($request->getExists('id'))
            {
                $news->setId($request->getData('id'));
            }
        }
        else
        {
            if ($request->getExists('id'))
            {
                $news = $this->managers->getManagerOf('News')->getNewscUniqueUsingNewsId($request->getData('id'));
            }
            else
            {
                $news = new News;
            }
        }

        $formBuilder = new NewsFormBuilder($news);
        $formBuilder->build();

        $form = $formBuilder->form();

        $formHandler = new \OCFram\FormHandler($form, $this->managers->getManagerOf('News'), $request);

        if ($news->isNew() | ($this->app->user()->rule() == \Entity\Author::RULE_ADMIN | $this->app->user()->sessionUser() == (int)$news->FNC_fk_FAC())) {
            if ($formHandler->process()) {
                $this->app->user()->setFlash($news->isNew() ? 'La news a bien été ajoutée !' : 'La news a bien été modifiée !');
                $this->app->httpResponse()->redirect($this->app->getHref('index','Backend', 'News'));
            }
            $this->page->addVar('form', $form->createView());
        }
        else {
            $this->app->user()->setFlash('Vous n\'etes pas auteur de cette news.');
            $this->app->httpResponse()->redirect($this->app->getHref('index','Frontend', 'News'));
        }
    }

    /**
     * Methode pour Update un commentaire
     * @param HTTPRequest $request
     */
    public function executeUpdateComment(HTTPRequest $request)
    {
        $this->createMenu();
        $this->page->addVar('title', 'modification d\'un commentaire');

        if($request->getExists('id')) {
            $fcc_id = $request->getData('id');
        }

        $comment = $this->managers->getManagerOf('Comments')->get($fcc_id);
        if($request->method() == 'POST') {
            $comment = new Comment([
                'FCC_id' => $fcc_id,
                'FCC_fk_FAC' => $comment->FCC_fk_FAC(),
                'FCC_fk_FNC' => $comment->FCC_fk_FNC(),
                'FCC_content' => $request->postData('FCC_content')
            ]);
            $comment->setId($fcc_id);
        }

        $formBuilder = new CommentFormBuilder($comment);
        $formBuilder->build();

        $form = $formBuilder->form();

        $formHandler = new FormHandler($form, $this->managers->getManagerOf('Comments'), $request);

        $this->redirectUser();
        //if($this->app->user()->sessionUser() == $comment->FCC_fk_FAC()) {
        if ($formHandler->process()) {
            $this->app->user()->setFlash('Le commentaire a bien été modifié');
            $this->app->httpResponse()->redirect('/news-'.$comment->FCC_fk_FNC().'.html');
            //$this->app->httpResponse()->redirect($this->app->getHref('testJSON','Frontend', 'News'));
        }
        $this->page->addVar('form', $form->createView());
    }

    /**
     * @param HTTPRequest $request
     */
    public function executeDeleteComment(HTTPRequest $request)
    {
        $this->createMenu();
        if($request->getExists('id')) {
            $fcc_id = $request->getData('id');
        }
        $comment = $this->managers->getManagerOf('Comments')->get($fcc_id);                 //Je recupere le comment par son id
        $id = $comment->FCC_fk_FNC();
        if($this->app->user()->sessionUser() == \Entity\Author::RULE_ADMIN | $this->app->user()->sessionUser() == (int)$comment->FCC_fk_FAC()) {
            $this->managers->getManagerOf('Comments')->delete($fcc_id);
            $this->app->user()->setFlash('Le commentaire a bien été supprimé !');
            $this->app->httpResponse()->redirect('/news-'.$id.'.html');
            //$this->app->httpResponse()->redirect($this->app->getHref('testJSON','Frontend', 'News'));
        }
    }
}