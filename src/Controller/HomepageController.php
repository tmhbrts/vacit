<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Job;

/**
 * @Route("/")
 */
class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function index()
    {
        $rep = $this->getDoctrine()->getRepository(Job::class);
        $jobs = $rep->findLatest(5);
        return ['jobs' => $jobs];
    }

    /**
     * @Route("/jobs", name="jobs")
     * @Template()
     */
    public function jobs()
    {
        $rep = $this->getDoctrine()->getRepository(Job::class);
        $jobs = $rep->findAll();
        return ['jobs' => $jobs];
    }
}