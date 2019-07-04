<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\UserService;
use App\Service\CityService;

class UserController extends AbstractController
{
    private $us;
    private $cs;

    /**
     * @Route("/edit-profile", name="profile")
     * @Template()
     */
    public function profile(Request $post)
    {
        $user = $this->getUser();
        $cities = $this->cs->findAZ('name');
        $params = $post->request->all();
        if(!empty($params)) {
          $this->us->updateProfile($user, $params);
        }
        return ['user' => $user,
                'params' => $params,
                'cities' => $cities];
    }

    public function __construct(UserService $us,
                                CityService $cs)
    {
      $this->us = $us;
      $this->cs = $cs;
    }
}
