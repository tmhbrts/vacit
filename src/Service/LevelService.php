<?php

namespace App\Service;

use App\Entity\Level;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\EntityService;

class LevelService extends EntityService
{
    public function __construct(EntityManagerInterface $em)
    {
      parent::__construct($em, Level::class);
    }
}
