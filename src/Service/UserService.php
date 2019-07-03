<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\EntityService;

class UserService
{
    public function __construct(EntityManagerInterface $em)
    {
      parent::__construct($em, User::class);
    }
}
