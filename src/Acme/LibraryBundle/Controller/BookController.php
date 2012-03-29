<?php

namespace Acme\LibraryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Acme\LibraryBundle\Model\Book;
use Acme\LibraryBundle\Model\BookQuery;
use Acme\LibraryBundle\Form\Type\BookType;

class BookController extends Controller
{
    public function newAction()
    {
        $book = new Book();
        $form = $this->createForm(new BookType(), $book);

        $request = $this->getRequest();

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $book->save();

                return $this->redirect($this->generateUrl('books'));
            }
        }

        return $this->render('AcmeLibraryBundle:Book:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function listAction()
    {
        return $this->render('AcmeLibraryBundle:Book:list.html.twig', array(
            'books' => BookQuery::create()->find(),
        ));
    }
}
