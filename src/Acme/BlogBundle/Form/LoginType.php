<?php

namespace Acme\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('username', 'text', array('label' => 'Username'))
            ->add('password', 'password', array('label' => 'Password'))
            ->add('remember_me', 'checkbox', array('label' => 'Keep me logged in'))
        ;
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'csrf_field_name' => '_token',
            'intention'       => 'authenticate'
        );
    }

    public function getName()
    {
        return 'login';
    }
}
