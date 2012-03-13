<?php

namespace Acme\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\MinLength;
use Symfony\Component\Validator\Constraints\NotBlank;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('content', 'textarea', array(
                'label' => 'Your Comment',
                'attr' => array(
                    'class' => 'span6',
                ),
            ))
        ;
    }

    public function getDefaultOptions(array $options)
    {
        $validation = new Collection(array(
            'content'   => array(new NotBlank(), new MinLength(array('limit' => 10))),
        ));

        return array(
            'data_class' => 'Acme\BlogBundle\Model\Comment',
            #'validation_constraint' => $validation,
        );
    }

    public function getName()
    {
        return 'post';
    }
}
