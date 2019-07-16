<?php

namespace App\Service;

use App\Entity\Application;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\EntityService;
use App\Service\JobService;

class ApplicationService extends EntityService
{
    private $js; //to contain autowired JobService

    /* -------------------------------------------------------------------------
    get Job object, given $id. create new Application, given User object $candidate and
    found Job. return created Application object.
    ------------------------------------------------------------------------- */
    public function applyForJob($id, $candidate)
    {
        $job = $this->js->find($id);
        $application = $this->rep->create($job, $candidate);
        return $application;
    }

    /* -------------------------------------------------------------------------
    get Job object, given $id. get found Job's applications. return found
    Applications.
    ------------------------------------------------------------------------- */
    public function getApplicationsForJob($id)
    {
        $job = $this->js->find($id);
        $applications = $job->getApplications();
        return $applications;
    }

    /* -------------------------------------------------------------------------
    find Application object, given $id. set the invitation status of found
    Application object to true.
    ------------------------------------------------------------------------- */
    public function setInvitation($id)
    {
        $application = $this->find($id);
        $application = $this->rep->setInvitation($application);
        return $application;
    }

    /* -------------------------------------------------------------------------
    find Application object, given $id. return true if found Apllication
    object's andidate is equal to given $candidate.
    ------------------------------------------------------------------------- */
    public function checkOwnership($id, $candidate)
    {
        $application = $this->find($id);
        $candidateApplications = $candidate->getApplications();
        foreach($candidateApplications as $candidateApplication) {
            if($application == $candidateApplication) {
                return true;
            }
        }
    }

    /* -------------------------------------------------------------------------
    autowire EntityManagerInterface and JobService. construct parent
    (EntityService) giving $em and the Entity 'Application' as arguments.
    ------------------------------------------------------------------------- */
    public function __construct(EntityManagerInterface $em,
                                JobService $js)
    {
        $this->js = $js;
        parent::__construct($em, Application::class);
    }
}
