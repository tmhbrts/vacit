<?php

namespace App\Service;

use App\Entity\Job;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\EntityService;

class JobService extends EntityService
{
    public function findLatest($limit)
    {
      return $this->rep->createQueryBuilder('q')
                       ->orderBy('q.date', 'DESC')
                       ->setMaxResults($limit)
                       ->getQuery()
                       ->getResult();
    }

    public function __construct(EntityManagerInterface $em)
    {
      parent::__construct($em, Job::class);
    }
}
