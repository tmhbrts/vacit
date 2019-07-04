<?php

namespace App\Service;

use App\Entity\Application;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\EntityService;

class ApplicationService extends EntityService
{
    private $em;

    public function applyForJob($job, $user)
    {
      $application = new Application();
      $application->setJob($job);
      $application->setCandidate($user);
      $application->setDate(new \DateTime('now'));

      $this->em->persist($application);
      $this->em->flush();
    }

    public function __construct(EntityManagerInterface $em)
    {
      $this->em = $em;
      parent::__construct($em, Application::class);
    }
}
