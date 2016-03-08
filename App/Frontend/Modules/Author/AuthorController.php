<?php

/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 08/03/2016
 * Time: 15:20
 */

namespace App\Frontend\Modules\Author;

use \Entity\Author;
use \FormBuilder\AuthorFormBuilder;
use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \OCFram\FormHandler;

class AuthorController extends BackController
{
    public function executeNewAuthor(HTTPRequest $request)
    {
        $this->page->addVar('title', 'Nouvel Auteur');

        if($request->method() == 'POST') {
            $author = new Author([
                'lastname' => $request->postData('lastname'),
                'firstname' => $request->postData('firstname'),
                'username' => $request->postData('username'),
                'password' => $request->postData('password')
            ]);
        }
        else {
            $author = new Author;
        }

        $formBuilder = new AuthorFormBuilder($author);
        $formBuilder->build();

        $form = $formBuilder->form();

        $formHandler = new FormHandler($form, $this->managers->getManagerOf('Author'), $request);

        if($formHandler->process())
        {
            $this->app->user()->setFlash('Nouvel Utilisateur/Auteur Crée !');
            $this->app->httpResponse()->redirect('.');
        }
        $this->page->addVar('comment', $author);
        $this->page->addVar('form', $form->createView());
        $this->page->addVar('title', 'Nouvel Auteur');
    }
}