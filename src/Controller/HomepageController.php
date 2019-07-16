<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\JobService;

/**
 * @Route("/")
 */
class HomepageController extends AbstractController
{
    private $js; //to contain autowired JobService

    /* -------------------------------------------------------------------------
    get latest 5 jobs. render 'index.html.twig'.
    ------------------------------------------------------------------------- */
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function index()
    {
        $jobs = $this->js->findLatest(5);
        return ['jobs' => $jobs];
    }

    /* -------------------------------------------------------------------------
    autowire JobService.
    ------------------------------------------------------------------------- */
    public function __construct(JobService $js)
    {
        $this->js = $js;
    }
}
