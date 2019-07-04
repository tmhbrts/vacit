<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\JobService;
use App\Service\ApplicationService;

class ApplicationController extends AbstractController
{
    private $js;
    private $as;

    /**
     * @Route("/apply", name="apply")
     * @Template()
     */
    public function apply(Request $post)
    {
        $user = $this->getUser();
        $id = $post->get('id');
        if($id) {
          $job = $this->js->find($id);
          $this->as->applyForJob($job, $user);
          return ['job' => $job];
        } else {
          return;
        }
    }

    public function __construct(JobService $js,
                                ApplicationService $as)
    {
      $this->js = $js;
      $this->as = $as;
    }
}
