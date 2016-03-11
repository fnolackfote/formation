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
    /**
     * @param HTTPRequest $request
     */
    public function executeIndex(HTTPRequest $request)
    {
        $number_of_news = $this->app->config()->get('nombre_news');
        $number_of_case_per_news = $this->app->config()->get('nombre_caracteres');

        $this->page->addVar('title', 'Liste des '.$number_of_news.' dernieres news');

        $manager = $this->managers->getManagerOf('News');

        $list_of_news = $manager->getNewscOrderByIdDesc_a(0, $number_of_news);

        foreach ($list_of_news as $news)
        {
            if (strlen($news->FNC_content()) > $number_of_case_per_news)
            {
                $debut = substr($news->FNC_content(), 0, $number_of_case_per_news);
                $debut = substr($debut, 0, strrpos($debut, ' ')) . '...';

                $news->setFNC_content($debut);
            }
        }

        $this->page->addVar('list_of_news', $list_of_news);
    }

    /**
     * @param HTTPRequest $request
     */
    public function executeShow(HTTPRequest $request)
    {
        $fnc_id = $request->getData('FNC_id');
        $_SESSION['news_id'] = $fnc_id;
        $news = $this->managers->getManagerOf('News')->getNewscUniqueUsingNewsId($fnc_id);
        $userPostNews = $this->managers->getManagerOf('Author')->getAuthorcByNewsId($fnc_id);
        $commentNews = $this->managers->getManagerOf('Comments')->getListOf($fnc_id);

        foreach($commentNews as $comment) {
            $userPostComment[$comment->FCC_id()] = $this->managers->getManagerOf('Author')->getAuthorcUniqueByAuthorcId($comment->FCC_fk_FAC());
        }

        if (empty($news))
        {
            $this->app->httpResponse()->redirect404();
        }

        $this->page->addVar('title', $news->FNC_title());
        $this->page->addVar('news', $news);
        $this->page->addVar('author', $userPostNews);
        $this->page->addVar('comments', $commentNews);
        if(!empty($userPostComment)){
            $this->page->addVar('authorComment', $userPostComment);
        }
    }

    /**
     * @param HTTPRequest $request
     */
    public function executeInsertComment(HTTPRequest $request)
    {
        $this->page->addVar('title', 'Ajout d\'un commentaire');

        $fcc_fk_fnc = $_SESSION['news_id'];

        if($request->method() == 'POST') {
            $comment = new Comment([
                'FCC_fk_FNC' => $fcc_fk_fnc,
                'FCC_email' => empty($request->postData('FCC_email')) ? '' : $request->postData('FCC_email'),
                'FCC_username' => $request->postData('FCC_username'),
                'FCC_content' => $request->postData('FCC_content')
            ]);
        }
        else {
            $comment = new Comment;
        }

        $formBuilder = new CommentFormBuilder($comment);
        $formBuilder->build();

        $form = $formBuilder->form();

        $formHandler = new FormHandler($form, $this->managers->getManagerOf('Comments'), $request);

        if($formHandler->process())
        {
            $this->app->user()->setFlash('Le commentaire a bien été ajouté, merci !');
            $this->app->httpResponse()->redirect('news-'.$fcc_fk_fnc.'.html');
        }
        $this->page->addVar('comment', $comment);
        $this->page->addVar('formInsertComment', $form->createView());
        $this->page->addVar('title', 'Ajout d\'un commentaire');
    }
}