<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\JobService;

class JobController extends AbstractController
{
    private $js;

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
        $this->denyAccessUnlessGranted('ROLE_EMPLOYER', null, 'Niet toegestaan');
        $user = $this->getUser();
        $jobs = $user->getJobs();
        return ['jobs' => $jobs];
    }

    /**
     * @Route("/remove-job", name="remove_job")
     * @Template()
     */
    public function remove(Request $post)
    {
        $id = $post->get('id');
        $this->js->remove($id);
        return ['id' => $id];
    }

    public function __construct(JobService $js) {
      $this->js = $js;
    }
}
