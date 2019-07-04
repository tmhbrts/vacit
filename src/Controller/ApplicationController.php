<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Service\ApplicationService;

class ApplicationController extends AbstractController
{
    private $as;

    /**
     * @Route("/apply", name="apply")
     * @Template()
     */
    public function apply(Request $post)
    {
        $id = $post->get('id');
        if($id) {
          $candidate = $this->getUser();
          $application = $this->as->applyForJob($id, $candidate);
          return ['application' => $application];
        } else {
          return $this->redirectToRoute('homepage');
        }
    }

    public function __construct(ApplicationService $as)
    {
      $this->as = $as;
    }
}
