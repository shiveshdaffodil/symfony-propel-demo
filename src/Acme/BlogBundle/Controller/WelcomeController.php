<?php

namespace Acme\BlogBundle\Controller;

use Acme\BlogBundle\Form\LoginType;

class WelcomeController extends BaseController
{
    public function indexAction()
    {
        return $this->render('AcmeBlogBundle:Welcome:index.html.twig');
    }

    public function loginAction()
    {
        $form = $this->container->get('form.factory')->create(new LoginType());

        return $this->render('AcmeBlogBundle:Welcome:login.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
