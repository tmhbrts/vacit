<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\JobService;

/**
 * @Route("/jobs")
 */
class JobController extends AbstractController
{
    private $js;

    /**
     * @Route("/", name="job_index")
     * @Template()
     */
    public function index()
    {
        $jobs = $this->js->findAll();
        return ['jobs' => $jobs];
    }

    /**
     * @Route("/{id<\d+>}", name="job_show")
     * @Template()
     */
    public function show($id)
    {
        $job = $this->js->find($id);
        return ['job' => $job];
    }

    public function __construct(JobService $js) {
      $this->js = $js;
    }
}
