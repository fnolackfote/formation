<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 04/03/2016
 * Time: 16:23
 */

namespace FormBuilder;

use \OCFram\FormBuilder;
use \OCFram\StringField;
use \OCFram\TextField;
use \OCFram\MaxLengthValidator;
use \OCFram\NotNullValidator;

class NewsFormBuilder extends FormBuilder
{
    public function build()
    {
        $this->form->add(new StringField([
            'label' => 'Titre',
            'name' => 'FNC_title',
            'maxLength' => 100,
            'validators' => [
                new MaxLengthValidator('Le titre spécifié est trop long (100 caractères maximum)', 100),
                new NotNullValidator('Merci de spécifier le titre de la news')
            ],
        ]))
        ->add(new TextField([
            'label' => 'Contenu',
            'name' => 'FNC_content',
            'rows' => 8,
            'cols' => 60,
            'validators' => [
                new NotNullValidator('Merci de spécifier le contenu de la news'),
            ],
        ]));
    }
}