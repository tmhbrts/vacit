<?php

namespace App\Service;

use App\Entity\City;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\EntityService;

class CityService extends EntityService
{
    public function findCity($cityName): ?City
    {
      return $this->createQueryBuilder('c')
                  ->andWhere('c.city = :city_name')
                  ->setParameter('city_name', $cityName)
                  ->getQuery()
                  ->getOneOrNullResult();
    }

    public function __construct(EntityManagerInterface $em)
    {
      parent::__construct($em, City::class);
    }
}
