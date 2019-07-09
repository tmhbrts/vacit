<?php

namespace App\Repository;

use App\Entity\Job;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Job|null find($id, $lockMode = null, $lockVersion = null)
 * @method Job|null findOneBy(array $criteria, array $orderBy = null)
 * @method Job[]    findAll()
 * @method Job[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobRepository extends ServiceEntityRepository
{
    public function update($job, $params)
    {
      $job->setTitle($params["title"]);
      $job->setLevel($params["level"]);
      $job->setCity($params["city"]);
      $job->setDescription($params["description"]);

      $em = $this->getEntityManager();
      $em->persist($job);
      $em->flush();

      return $job;
    }

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Job::class);
    }
}
