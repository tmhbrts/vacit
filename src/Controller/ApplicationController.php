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
    private $as; //to contain autowired ApplicationService

    /* -------------------------------------------------------------------------
    create application, given current user and value of 'id' from Request $post.
    render template '/apply.html.twig'.
    ------------------------------------------------------------------------- */
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

    /* -------------------------------------------------------------------------
    get applications from current user. render template
    'my_applications.html.twig'.
    ------------------------------------------------------------------------- */
    /**
     * @Route("/my-applications", name="my_applications")
     * @Template()
     */
    public function myApplications()
    {
        $user = $this->getUser();
        $applications = $user->getApplications();
        return ['applications' => $applications];
    }

    /* -------------------------------------------------------------------------
    routing is used for ajax request. remove application, given value of 'id'
    from Request $post. render template 'remove.html.twig'.
    ------------------------------------------------------------------------- */
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

    /* -------------------------------------------------------------------------
    get applications from job with $id specified in routing. render template
    'job_applications.html.twig'.
    ------------------------------------------------------------------------- */
    /**
     * @Route("job-applications/{id<\d+>}", name="job_applications")
     * @Template()
     */
    public function jobApplications($id)
    {
        $applications = $this->as->getApplicationsForJob($id);
        return ['applications' => $applications];
    }

    /* -------------------------------------------------------------------------
    routing is used for ajax request. set invitation for application, given
    value of 'id' from Request $post. render template 'invite.html.twig'
    ------------------------------------------------------------------------- */
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

    /* -------------------------------------------------------------------------
    autowire ApplicationService
    ------------------------------------------------------------------------- */
    public function __construct(ApplicationService $as)
    {
        $this->as = $as;
    }
}
