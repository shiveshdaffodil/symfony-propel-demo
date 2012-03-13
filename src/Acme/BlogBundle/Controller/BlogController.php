<?php

namespace Acme\BlogBundle\Controller;

use Acme\BlogBundle\Form\CommentType;
use Acme\BlogBundle\Model\Comment;
use Acme\BlogBundle\Model\Post;
use Acme\BlogBundle\Model\PostPeer;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BlogController extends BaseController
{
    public function indexAction()
    {
        $posts = PostPeer::doSelect(new \Criteria());

        return $this->render('AcmeBlogBundle:Blog:index.html.twig', array(
            'posts' => $posts,
        ));
    }

    public function showAction($slug)
    {
        if (!$post = PostPeer::retrieveBySlug($slug)) {
            throw new NotFoundHttpException('The requested post does not exist.');
        }

        $comment = new Comment();
        $commentForm = $this->createForm(new CommentType(), $comment);

        return $this->render('AcmeBlogBundle:Blog:show.html.twig', array(
            'post' => $post,
            'comment_form' => $commentForm->createView(),
        ));
    }

    public function commentAction($slug)
    {
        if (!$this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedHttpException('You must be logged in to post a comment.');
        }

        if (!$post = PostPeer::retrieveBySlug($slug)) {
            throw new NotFoundHttpException('The requested post does not exist.');
        }

        $comment = new Comment();
        $form = $this->createForm(new CommentType(), $comment);
        $form->bindRequest($this->getRequest());

        if ($form->isValid()) {
            $comment
                ->setPost($post)
                ->setUser($this->getUserModel())
                ->save()
            ;

            return $this->redirect($this->generateUrl('_post', array('slug' => $slug)));
        }

        return $this->render('AcmeBlogBundle:Blog:show.html.twig', array(
            'post' => $post,
            'comment_form' => $form->createView(),
        ));
    }
}
