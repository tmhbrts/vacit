<?php

namespace App\Service;

use App\Entity\Job;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\EntityService;
use App\Service\PlatformService;
use App\Service\LevelService;
use App\Service\CityService;

class JobService extends EntityService
{
    private $ps; //to contain autowired PlatformService
    private $ls; //to contain autowired LevelService
    private $cs; //to contain autowired CityService

    /* -------------------------------------------------------------------------
    return an array of the latest Job objects returned by
    JobRepository's querybuilder, given $limit as amount of results to return
    ------------------------------------------------------------------------- */
    public function findLatest($limit)
    {
        return $this->rep->createQueryBuilder('q')
                         ->orderBy('q.date', 'DESC')
                         ->setMaxResults($limit)
                         ->getQuery()
                         ->getResult();
    }

    /* -------------------------------------------------------------------------
    find Job object, given $id. find Platform, Level and City objects, given
    $params' eponymous key value pairs. set values of these pairs to found
    objects. call JobRepository's update function giving found Job object and
    $params as arguments.
    ------------------------------------------------------------------------- */
    public function update($id, $params)
    {
        $job = $this->find($id);
        $params["platform"] = $this->ps->find($params["platform"]);
        $params["level"] = $this->ls->find($params["level"]);
        $params["city"] = $this->cs->find($params["city"]);
        return $this->rep->update($job, $params);
    }

    /* -------------------------------------------------------------------------
    find Job object, given $id. find Platform, Level and City objects, given
    $params' eponymous key value pairs. set values of these pairs to found
    objects. return updated Job object returned by JobRepository's update
    function, giving found Job object and $params as arguments.
    ------------------------------------------------------------------------- */
    public function create($employer)
    {
        return $this->rep->create($employer);
    }

    /* -------------------------------------------------------------------------
    find Job object, given $id. find an array of Job objects from given User
    object $employer. return true if found Job object is in array.
    ------------------------------------------------------------------------- */
    public function checkOwnership($id, $employer)
    {
        $job = $this->find($id);
        $employerJobs = $employer->getJobs();
        foreach($employerJobs as $employerJob) {
            if($job == $employerJob) {
                return true;
            }
        }
    }

    /* -------------------------------------------------------------------------
    autowire EntityManagerInterface and Services. construct parent
    (EntityService) giving $em and the Entity 'Job' as arguments.
    ------------------------------------------------------------------------- */
    public function __construct(EntityManagerInterface $em,
                                PlatformService $ps,
                                LevelService $ls,
                                CityService $cs)
    {
        $this->ps = $ps;
        $this->ls = $ls;
        $this->cs = $cs;
        parent::__construct($em, Job::class);
    }
}
