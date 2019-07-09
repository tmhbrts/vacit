<?php

namespace App\Repository;

use App\Entity\Application;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ApplicationRepository extends ServiceEntityRepository
{
    public function create($job, $candidate)
    {
        $exists = $this->findBy(['job' => $job,
                                 'candidate' => $candidate]);
        if($exists) {
            return;
        } else {
            $application = new Application();
            $application->setJob($job);
            $application->setCandidate($candidate);

            $em = $this->getEntityManager();
            $em->persist($application);
            $em->flush();

            return $application;
        }
    }

    public function setInvitation($application)
    {
        $application->setInvitation(true);

        $em = $this->getEntityManager();
        $em->persist($application);
        $em->flush();

        return $application;
    }

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Application::class);
    }
}
