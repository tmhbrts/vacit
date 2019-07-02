<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\UserService;

class UserController extends AbstractController
{
    private $us;

    /**
     * @Route("/edit-profile", name="profile")
     * @Template()
     */
    public function profile()
    {
        $user = $this->getUser();
        return ['user' => $user];
    }

    public function __construct(UserService $us) {
      $this->us = $us;
    }
}
