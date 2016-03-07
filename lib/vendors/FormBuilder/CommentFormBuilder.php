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
    public function build()
    {
        $this->form->add(new StringField([
            'label' => 'Auteur',
            'name' => 'author',
            'maxLength' => 50,
           /* 'validators' => [
                new MaxLengthValidator('50 caractere minimum pour le nom de l\auteur', 50),
                new NotNullValidator('Merci de spécifier le nom de l\'auteur'),
            ],*/
            ]))
            ->add(new TextField([
            'label' => 'Contenu',
            'name' => 'content',
            'rows' => 7,
            'cols' => 50,
            'validators' => [
                new NotNullValidator('Merci de spécifier votre commentaire'),
            ],
        ]));
    }
}