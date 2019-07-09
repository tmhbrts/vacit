<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Service\JobService;
use App\Service\CityService;
use App\Service\LevelService;

class JobController extends AbstractController
{
    private $js;
    private $cs;
    private $ls;

    /**
     * @Route("/jobs", name="job_index")
     * @Template()
     */
    public function index()
    {
        $jobs = $this->js->findAll();
        return ['jobs' => $jobs];
    }

    /**
     * @Route("job/{id<\d+>}", name="job_show")
     * @Template()
     */
    public function show($id)
    {
        $job = $this->js->find($id);
        return ['job' => $job];
    }

    /**
     * @Route("/my-jobs", name="my_jobs")
     * @Template()
     */
    public function myJobs()
    {
        $user = $this->getUser();
        $jobs = $user->getJobs();
        return ['jobs' => $jobs];
    }

    /**
     * @Route("/job/new", name="new_job")
     * @Template()
     */
    public function create()
    {
        $employer = $this->getUser();
        $job = $this->js->create($employer);
        $id = $job->getId();
        return $this->redirectToRoute('edit_job', ['id' => $id]);
    }

    /**
     * @Route("job/{id<\d+>}/edit", name="edit_job")
     * @Template()
     */
    public function edit($id, Request $post)
    {
        $user = $this->getUser();
        $params = $post->request->all();
        if(!empty($params) && $this->js->checkOwnership($id, $user)) {
            $this->js->update($id, $params);
        }
        $job = $this->js->find($id);
        $levels = $this->ls->findAll();
        $cities = $this->cs->findAZ('name');
        return ['job' => $job,
                'levels' => $levels,
                'cities' => $cities];
    }

    /**
     * @Route("/remove-job", name="remove_job")
     * @Template()
     */
    public function remove(Request $post)
    {
        $id = $post->get('id');
        $employer = $this->getUser();
        if($this->js->checkOwnership($id, $employer)) {
            $this->js->remove($id);
            return ['id' => $id];
        }
    }

    public function __construct(JobService $js,
                                CityService $cs,
                                LevelService $ls)
    {
        $this->js = $js;
        $this->cs = $cs;
        $this->ls = $ls;
    }
}
