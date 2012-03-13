<?php

namespace Acme\BlogBundle\Security;

use Propel\PropelBundle\Security\User\ModelUserProvider;

class UserProvider extends ModelUserProvider
{
    public function __construct()
    {
        parent::__construct('Acme\BlogBundle\Model\User', 'Acme\BlogBundle\Security\UserProxy', 'username');
    }
}