<?php

namespace Acme\BlogBundle\Model;

use Acme\BlogBundle\Model\om\BasePost;

class Post extends BasePost
{
    /**
     * Return the Creator of this Post.
     *
     * @param \PropelPDO $con
     *
     * @return User
     */
    public function getCreator(\PropelPDO $con = null)
    {
        return $this->getUserRelatedByCreatedBy($con);
    }
}
