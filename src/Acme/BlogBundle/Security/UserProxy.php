<?php

namespace Acme\BlogBundle\Security;

use Symfony\Component\Security\Core\User\UserInterface;
use Acme\BlogBundle\Model\User;

class UserProxy implements UserInterface
{
    /**
     * The model user
     *
     * @var \Acme\BlogBundle\Model\User
     */
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getRoles()
    {
        return $this->getUser()->getRoles();
    }

    public function getPassword()
    {
        return $this->getUser()->getPassword();
    }

    public function getSalt()
    {
        return $this->getUser()->getSalt();
    }

    public function getUsername()
    {
        return $this->getUser()->getUsername();
    }

    public function eraseCredentials()
    {
        // Nothing to do with that user model.
    }

    public function equals(UserInterface $user)
    {
        return $this->getUser()->getUsername() === $user->getUsername();
    }

    public function getPrimaryKey()
    {
        return $this->getUser()->getPrimaryKey();
    }

    /**
     * @return \Acme\BlogBundle\Model\User
     */
    protected function getUser()
    {
        return $this->user;
    }
}