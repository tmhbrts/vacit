<?php

namespace App\Service;

use App\Entity\Job;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\EntityService;
use App\Service\LevelService;
use App\Service\CityService;

class JobService extends EntityService
{
    private $ls;
    private $cs;

    public function findLatest($limit)
    {
        return $this->rep->createQueryBuilder('q')
                         ->orderBy('q.date', 'DESC')
                         ->setMaxResults($limit)
                         ->getQuery()
                         ->getResult();
    }

    public function update($id, $params)
    {
        $job = $this->find($id);
        $params["level"] = $this->ls->find($params["level"]);
        $params["city"] = $this->cs->find($params["city"]);
        $this->rep->update($job, $params);
    }

    public function create($employer)
    {
        return $this->rep->create($employer);
    }

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

    public function __construct(EntityManagerInterface $em,
                                LevelService $ls,
                                CityService $cs)
    {
        $this->ls = $ls;
        $this->cs = $cs;
        parent::__construct($em, Job::class);
    }
}
