<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 08/03/2016
 * Time: 14:41
 */

namespace FormBuilder;


use \OCFram\FormBuilder;
use \OCFram\StringField;
use \OCFram\MaxLengthValidator;
use \OCFram\NotNullValidator;

class AuthorFormBuilder extends FormBuilder
{
    public function build()
    {
        $this->form->add(new StringField([
            'label' => 'Prenom',
            'name' => 'FAC_firstname',
            'type' => 'text',
            'require' => 'require',
            'maxLength' => 50,
            /*'validators' => [
                new MaxLengthValidator('le prénom entré est trop long (50 caractères maximum)', 50),
                new NotNullValidator('Merci de spécifier votre prénom')
            ],*/
        ]))
        ->add(new StringField([
            'label' => 'Nom',
            'name' => 'FAC_lastname',
            'type' => 'text',
            'require' => 'require',
            'maxLength' => 50,
            /*'validators' => [
                new MaxLengthValidator('le nom entré est trop long (50 caractères maximum)', 50),
                new NotNullValidator('Merci de spécifier votre nom')
            ],*/
        ]))
        ->add(new StringField([
            'label' => 'Nom Utilisateur',
            'name' => 'FAC_username',
            'type' => 'text',
            'require' => 'require',
            'maxLength' => 50,
            /*'validators' => [
                new MaxLengthValidator('le nom d\'utilisateur entré est trop long (50 caractères maximum)', 50),
                new NotNullValidator('Merci de spécifier votre nom d\'utilisateur')
            ],*/
        ]))
        ->add(new StringField([
            'label' => 'Mot de passe',
            'name' => 'FAC_password',
            'type' => 'password',
            'require' => 'require',
            'maxLength' => 20,
            /*'validators' => [
                new MaxLengthValidator('le mot de passe est trop long (20 caractères maximum)', 20),
                new NotNullValidator('Merci de spécifier votre mot de passe')
            ],*/
        ]));
    }

}