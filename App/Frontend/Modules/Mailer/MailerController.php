<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 11/03/2016
 * Time: 10:08
 */

namespace \App\Frontend\Modules\Mailer;

use \OCFram\BackController;
use \OCFram\HTTPRequest;

class MailerController extends BackController
{

    /**
     * Envoyer un mail a tous les users ayant commentzer une news lorsque cette meme news viens d'être commente.
     * on recupere les email des comments. s'il n'y a pas d'email, on recupere les email des user a partir de l'id du comment.
     * @param HTTPRequest $request
     */
    public function executeMailer(HTTPRequest $request)
    {
        $mail = new \PHPMailer;
        $mail->isSMTP();
        $mail->Username = '';
        $mail->Password = '';
        $mail->Port = '';



        $mail->setFrom();
        $mail->addAddress();
        $mail->addReplyTo();

        $mail->isHTML(true);

        if($mail->send())
        {
            $this->app->user()->setFlash('Le mail a bien ete envoyer');
            //$this->app->httpResponse()->redirect('news-'.$fcc_fk_fnc.'.html');
        }
        $this->app->user()->setFlash('Le Mail n\'a pas été envoyé. '.$mail->ErrorInfo);
    }

}