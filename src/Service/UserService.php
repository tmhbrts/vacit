<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    private $rep;

    public function __construct(EntityManagerInterface $em)
    {
      $this->rep = $em->getRepository(User::class);
    }
}
