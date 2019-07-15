<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\UserService;
use App\Service\CityService;
use App\Service\UploadService;

class UserController extends AbstractController
{
    private $us;
    private $cs;

    /**
     * @Route("/candidate/{id<\d+>}", name="show_candidate")
     * @Template()
     */
    public function showCandidate($id)
    {
        $candidate = $this->us->find($id);
        return ['user' => $candidate];
    }

    /**
     * @Route("/employer/{id<\d+>}", name="show_employer")
     * @Template()
     */
    public function showEmployer($id)
    {
        $employer = $this->us->find($id);
        return ['user' => $employer];
    }

    /**
     * @Route("/edit-profile", name="edit_profile")
     * @Template()
     */
    public function editProfile(Request $post)
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

    /**
     * @Route("/upload-picture", name="upload_picture")
     */
    public function uploadPicture()
    {
      $upload_dir = 'upload_files/';
      $uploader = new UploadService('uploadpicture');

      $result = $uploader->handleUpload($upload_dir, ['jpg', 'jpeg', 'png']);

      if ($result) {
        $status = ['success' => true];
        return new JsonResponse($status);
      } else {
        $status = ['success' => false, 'msg' => $uploader->getErrorMsg()];
        return new JsonResponse($status);
      }
    }

    /**
     * @Route("/upload-cv", name="upload_cv")
     */
    public function uploadCv()
    {
      $upload_dir = 'upload_files/';
      $uploader = new UploadService('uploadcv');

      $result = $uploader->handleUpload($upload_dir, ['pdf', 'doc', 'docx']);

      if ($result) {
        $status = ['success' => true];
        return new JsonResponse($status);
      } else {
        $status = ['success' => false, 'msg' => $uploader->getErrorMsg()];
        return new JsonResponse($status);
      }
    }

    public function __construct(UserService $us,
                                CityService $cs)
    {
        $this->us = $us;
        $this->cs = $cs;
    }
}
