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
use App\Service\PlatformService;

class JobController extends AbstractController
{
    private $js; //to contain autowired JobService
    private $cs; //to contain autowired CityService
    private $ls; //to contain autowired LevelService
    private $ps; //to contain autowired PlatformService

    /* -------------------------------------------------------------------------
    find all jobs. render template 'index.html.twig'
    ------------------------------------------------------------------------- */
    /**
     * @Route("/jobs", name="job_index")
     * @Template()
     */
    public function index()
    {
        $jobs = $this->js->findAll();
        return ['jobs' => $jobs];
    }

    /* -------------------------------------------------------------------------
    get job with $id specified in routing. render template 'show.html.twig'.
    ------------------------------------------------------------------------- */
    /**
     * @Route("job/{id<\d+>}", name="job_show")
     * @Template()
     */
    public function show($id)
    {
        $job = $this->js->find($id);
        return ['job' => $job];
    }

    /* -------------------------------------------------------------------------
    get jobs of current user. render template 'my_jobs.html.twig'.
    ------------------------------------------------------------------------- */
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

    /* -------------------------------------------------------------------------
    create new empty job, given current user. redirect to routing "edit_job" for
    new job id.
    ------------------------------------------------------------------------- */
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

    /* -------------------------------------------------------------------------
    get $params from Request $post. if set, update job with $id specified in
    routing, given $params. get job with $id specified in routing. render
    template 'edit.html.tiwig'.
    ------------------------------------------------------------------------- */
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
        $cities = $this->cs->findAZ('name');
        $levels = $this->ls->findAll();
        $platforms = $this->ps->findAZ('name');
        return ['job' => $job,
                'levels' => $levels,
                'cities' => $cities,
                'platforms' => $platforms];
    }

    /* -------------------------------------------------------------------------
    routing is used for ajax request. remove job, given value of 'id'
    from Request $post. render template 'remove.html.twig'.
    ------------------------------------------------------------------------- */
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

    /* -------------------------------------------------------------------------
    autowire Services
    ------------------------------------------------------------------------- */
    public function __construct(JobService $js,
                                CityService $cs,
                                LevelService $ls,
                                PlatformService $ps)
    {
        $this->js = $js;
        $this->cs = $cs;
        $this->ls = $ls;
        $this->ps = $ps;
    }
}
