<?php

/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 08/03/2016
 * Time: 15:20
 */

namespace App\Frontend\Modules\Author;

use \OCFram\MainController;
use \Entity\Author;
use \FormBuilder\AuthorFormBuilder;
use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \OCFram\FormHandler;

class AuthorController extends BackController
{
    use MainController;

    public function executeNewAuthor(HTTPRequest $request)
    {
        $this->createMenu();
        $this->page->addVar('title', 'Nouvel Auteur');

        if($request->method() == 'POST') {
            $author = new Author([
                'FAC_lastname' => $request->postData('FAC_lastname'),
                'FAC_firstname' => $request->postData('FAC_firstname'),
                'FAC_email' => $request->postData('FAC_email'),
                'FAC_username' => $request->postData('FAC_username'),
                'FAC_password' => $request->postData('FAC_password'),
                'password' => $request->postData('password')
            ]);
        }
        else {
            $author = new Author;
        }

        if(!$this->app->user()->isAuthenticated()) {
            $formBuilder = new AuthorFormBuilder($author);
            $formBuilder->build();

            $form = $formBuilder->form();
            if($author->password() == $author->FAC_password()) {
                $formHandler = new FormHandler($form, $this->managers->getManagerOf('Author'), $request);

                if ($formHandler->process()) {
                    $this->app->user()->setFlash('Connecte en tant que <b>' . $author->FAC_username() . '</b>');
                    $this->app->user()->setSessionUser($author->FAC_id());
                    $this->app->user()->setAttribute('username', $author->FAC_username());
                    $this->app->user()->setAttribute('rule', $author->FAC_rule());
                    $this->app->user()->setRule($author->FAC_rule());
                    $this->app->user()->setAuthenticated(true);
                    $this->app->user()->setFlash('Nouvel Utilisateur/Auteur Crée !');
                    //$this->app->httpResponse()->redirect('/admin/');
                    $this->app->httpResponse()->redirect($this->app->getHref('index','Backend', 'News'));
                }
            } else {
                $this->page->addVar('errorPass', "Les mots de passe doivent être identique");
            }
            $this->page->addVar('author', $author);
            $this->page->addVar('formNewAuthor', $form->createView());
            $this->page->addVar('title', 'Nouvel Auteur');
        } else {
            $this->app->user()->setFlash('Vous avez deja un compte. Fermez la session actuelle !');
            //$this->app->httpResponse()->redirect('.');
            $this->app->httpResponse()->redirect($this->app->getHref('index','Frontend', 'News'));
        }
    }

    /**
     * Afficher les details d'un user
     * @param HTTPRequest $request
     *
     */
    public function executeDetail(HTTPRequest $request)
    {
        $this->createMenu();
        $this->redirectUser();
        $author_id = $request->getData('author_id');
        $userPost = $this->managers->getManagerOf('Author')->getAuthorcUniqueByAuthorcId($author_id);

        $this->page->addVar('author', $userPost);
        $this->page->addVar('news_author_a', $this->managers->getManagerOf('News')->getNewscByUsingAuthorId($author_id));
        $this->page->addVar('comment_author_a', $this->managers->getManagerOf('Comments')->getCommentcByUsingAuthorId($author_id));
        $this->page->addVar('title', 'Detail de l\'auteur');
    }

    public function executePass()
    {
        $this->managers->getManagerOf('Author')->getConnexion2();
    }
}