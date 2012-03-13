<?php

namespace Acme\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\MinLength;
use Symfony\Component\Validator\Constraints\NotBlank;

class PostType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('excerpt', 'textarea')
            ->add('content', 'textarea')
        ;
    }

    public function getDefaultOptions(array $options)
    {
        $validation = new Collection(array(
            'title'   => array(new NotBlank(), new MinLength(array('limit' => 10))),
            'excerpt' => array(new NotBlank(), new MinLength(array('limit' => 25))),
            'content' => array(new NotBlank(), new MinLength(array('limit' => 50))),
        ));

        return array(
            'data_class' => 'Acme\BlogBundle\Model\Post',
            #'validation_constraint' => $validation,
        );
    }

    public function getName()
    {
        return 'post';
    }
}
