<?php

namespace App\Service;

use App\Entity\City;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\EntityService;

class CityService extends EntityService
{
    /* -------------------------------------------------------------------------
    autowire EntityManagerInterface and JobService. construct parent
    (EntityService) giving $em and the Entity 'City' as arguments.
    ------------------------------------------------------------------------- */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, City::class);
    }
}
