<?php

namespace Acme\BlogBundle\Model;

use Acme\BlogBundle\Model\om\BasePostPeer;

class PostPeer extends BasePostPeer
{
    static public function retrieveBySlug($slug, \PropelPDO $con = null)
    {
        $criteria = new \Criteria(self::DATABASE_NAME);
        $criteria
            ->add(self::SLUG, $slug, \Criteria::EQUAL)
            ->addJoin(self::CREATED_BY, UserPeer::ID, \Criteria::INNER_JOIN)
        ;

        return self::doSelectOne($criteria, $con);
    }
}
