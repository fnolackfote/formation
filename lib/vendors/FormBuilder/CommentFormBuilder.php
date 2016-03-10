<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 04/03/2016
 * Time: 16:12
 */

namespace FormBuilder;

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
                'label' => 'Email',
                'name' => 'FCC_email',
                'maxLength' => 100,
                'validators' => [
                    new MaxLengthValidator('Le titre spécifié est trop long (100 caractères maximum)', 100),
                    new NotNullValidator('Merci de spécifier le titre de la news')
                    ],
                ]));
        }
        $this->form->add(new TextField([
                'label' => 'Contenu',
                'name' => 'FCC_content',
                'rows' => 7,
                'cols' => 50,
                'validators' => [
                    new NotNullValidator('Merci de spécifier votre commentaire'),
                ],
            ]));
    }
}