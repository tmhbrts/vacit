<?php

namespace App\Service;

use App\Entity\Job;
use Doctrine\ORM\EntityManagerInterface;

class JobService
{
    private $rep;

    public function find($id)
    {
      return $this->rep->find($id);
    }

    public function findAll()
    {
      return $this->rep->findAll();
    }

    public function findLatest($limit)
    {
      return $this->rep->findLatest($limit);
    }

    public function __construct(EntityManagerInterface $em)
    {
      $this->rep = $em->getRepository(Job::class);
    }
}
