<?php

namespace Acme\BlogBundle\Controller;

use Acme\BlogBundle\Model\UserQuery;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    public function getUserModel()
    {
        if (!$this->getUser()) {
            return null;
        }

        return UserQuery::create()->findOneByUsername($this->getUser()->getUsername());
    }
}
