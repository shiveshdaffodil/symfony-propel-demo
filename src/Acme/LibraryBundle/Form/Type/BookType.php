<?php

namespace Acme\LibraryBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class BookType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('title');
        $builder->add('isbn');
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Acme\LibraryBundle\Model\Book',
        );
    }

    public function getName()
    {
        return 'book';
    }
}
