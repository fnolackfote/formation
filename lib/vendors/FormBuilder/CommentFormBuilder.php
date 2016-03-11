<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 04/03/2016
 * Time: 16:12
 */

namespace FormBuilder;

use OCFram\EmailValidator;
use \OCFram\FormBuilder;
use \OCFram\StringField;
use \OCFram\TextField;
use \OCFram\MaxLengthValidator;
use \OCFram\NotNullValidator;

class CommentFormBuilder extends FormBuilder
{
    // TODO: $_SESSION['user_id'] Doit etre enleve ici.
    public function build()
    {
        if(empty($_SESSION['user_id'])){
            $this->form->add(new StringField([
                'label' => 'Nom Utilisateur',
                'name' => 'FCC_username',
                'type' => 'text',
                'maxLength' => 50,
                'validators' => [
                    new MaxLengthValidator('le nom d\'utilisateur spécifié est trop long (50 caractères maximum)', 50),
                    new NotNullValidator('Merci de spécifier le nom d\'utilisateur'),
                    ],
                ]))
            ->add(new StringField([
                'label' => 'Email',
                'name' => 'FCC_email',
                'type' => 'email',
                'maxLength' => 100,
                'validators' => [
                    new MaxLengthValidator('le mail est trop long (100 caractères maximum)', 100),
                    new EmailValidator('Ce mail est non valide')
                ],
            ]));
        }
        $this->form->add(new TextField([
                'label' => 'Contenu',
                'name' => 'FCC_content',
                'rows' => 7,
                'cols' => 50,
                'validators' => [
                    new NotNullValidator('Merci de spécifier le contenu de votre commentaire'),
                ],
            ]));
    }
}