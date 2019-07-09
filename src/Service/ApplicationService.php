<?php

namespace App\Service;

use App\Entity\Application;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\EntityService;
use App\Service\JobService;

class ApplicationService extends EntityService
{
    private $js;

    public function applyForJob($id, $candidate)
    {
      $job = $this->js->find($id);
      $application = $this->rep->create($job, $candidate);
      return $application;
    }

    public function getApplicationsForJob($id)
    {
      $job = $this->js->find($id);
      $applications = $job->getApplications();
      return $applications;
    }

    public function setInvitation($id)
    {
      $application = $this->find($id);
      $application = $this->rep->setInvitation($application);
      return $application;
    }

    public function checkOwnership($candidate, $application_id)
    {
      $application = $this->find($application_id);
      $candidateApplications = $candidate->getApplications();
      foreach($candidateApplications as $candidateApplication) {
        if($application == $candidateApplication) {
          return true;
        }
      }
    }

    public function __construct(EntityManagerInterface $em,
                                JobService $js)
    {
      $this->js = $js;
      parent::__construct($em, Application::class);
    }
}
