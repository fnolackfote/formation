<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 11/03/2016
 * Time: 10:08
 */

namespace App\Frontend\Modules\Mailer;

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
        if ($request->getExists('id_news')) {
            $fcc_fk_fnc = $request->getData('id_news');
        }

        $comment_a = $this->managers->getManagerOf("Comments")->getCommentcByUsingNewscIdExceptAuthorcId($fcc_fk_fnc, $this->app->user()->sessionUser());

        $mail = new \PHPMailer;
        $mail->isSMTP();

        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->SMTPDebug = 0;
        $mail->Debugoutput = 'html';
        $mail->Username = "dreamcenturyfaformation@gmail.com";
        $mail->Password = "UJ691vWtcdrm";
        $mail->SMTPSecure = "ssl";
        $mail->Port = 465;

        $mail->isHTML(true);

        $mail->setFrom('dreamcenturyfaformation@gmail.com', 'FANO DREAM');

        foreach ($comment_a as $comment) {
            if (!empty($comment->FCC_email())) {
                $mail->addAddress($comment->FCC_email(), $comment->FCC_username());

            } else if (!empty($comment->FCC_fk_FAC())) {
                $author_of_comment = $this->managers->getManagerOf("Author")->getAuthorcUniqueByAuthorcId($comment->FCC_fk_FAC());
                $mail->addAddress($author_of_comment->FAC_email(), $author_of_comment->FAC_username());
            }
        }

        $mail->addReplyTo('dreamcenturyfaformation@gmail.com');

        $mail->Subject = "Nouveau commentaire sur une news";

        $mail->Body = "Essai de l'envoi de mail";

        $mail->AltBody = "Message";

        if($this->app->user()->isAuthenticated()) {
            if ($mail->send()) {
                $this->app->user()->setFlash('Le mail a bien ete envoyer');
            } else {
                $this->app->user()->setFlash('Le Mail n\'a pas été envoyé. ' . $mail->ErrorInfo);
            }
        }
        //redirection vers la page de la news.
        $this->app->httpResponse()->redirect('news-'.$fcc_fk_fnc.'.html');
        //$this->app->httpResponse()->redirect('/');
    }
}