<?php

namespace Acme\LibraryBundle\Model;

use Acme\LibraryBundle\Model\om\BaseAuthor;

class Author extends BaseAuthor
{
    public function __toString()
    {
        return $this->getFirstName().' '.$this->getLastName();
    }
}
