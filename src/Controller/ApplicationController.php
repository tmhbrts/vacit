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
    private $user;

    /**
     * @Route("/apply", name="apply")
     * @Template()
     */
    public function apply(Request $post)
    {
        $id = $post->get('id');
        if($id) {
            $user = $this->getUser();
            $application = $this->as->applyForJob($id, $user);
            return ['application' => $application];
        } else {
            return $this->redirectToRoute('homepage');
        }
    }

    /**
     * @Route("/my-applications", name="my_applications")
     * @Template()
     */
    public function myApplications()
    {
        $this->denyAccessUnlessGranted('ROLE_CANDIDATE', null, 'Niet toegestaan');
        $user = $this->getUser();
        $applications = $user->getApplications();
        return ['applications' => $applications];
    }

    /**
     * @Route("/remove-application", name="remove_application")
     * @Template()
     */
    public function remove(Request $post)
    {
        $id = $post->get('id');
        $this->as->remove($id);
        return ['id' => $id];
    }

    /**
     * @Route("job-applications/{id<\d+>}", name="job_applications")
     * @Template()
     */
    public function jobApplications($id)
    {
        $this->denyAccessUnlessGranted('ROLE_EMPLOYER', null, 'Niet toegestaan');
        $applications = $this->as->getApplicationsForJob($id);
        return ['applications' => $applications];
    }

    /**
     * @Route("/invite", name="invite")
     * @Template()
     */
    public function invite(Request $post)
    {
        $id = $post->get('id');
        if($id) {
            $application = $this->as->setInvitation($id);
            return ['id' => $application->getId()];
        } else {
            return;
        }
    }


    public function __construct(ApplicationService $as)
    {
        $this->as = $as;
    }
}
