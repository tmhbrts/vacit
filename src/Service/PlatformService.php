<?php

namespace App\Service;

use App\Entity\Platform;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\EntityService;

class PlatformService extends EntityService
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, Platform::class);
    }
}
