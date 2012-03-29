<?php

namespace Acme\LibraryBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AuthorType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('first_name');
        $builder->add('last_name');
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Acme\LibraryBundle\Model\Author',
        );
    }

    public function getName()
    {
        return 'author';
    }
}
