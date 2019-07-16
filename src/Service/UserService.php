<?php

namespace App\Service;

use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Service\CityService;

class UserService
{
    private $um; //to contain autowired UserManagerInterface
    private $encoder; //to contain autowired UserPasswordEncoderInterface
    private $cs; //to contain autowired CityService

    /* -------------------------------------------------------------------------
    return User object returned by UserManagerInterface's findUserBy function,
    given $id.
    ------------------------------------------------------------------------- */
    public function find($id)
    {
      return $this->um->findUserBy(['id'=>$id]);
    }

    /* -------------------------------------------------------------------------
    update given $user, given $params
    ------------------------------------------------------------------------- */
    public function updateProfile($user, $params)
    {
        if(isset($params["picture_filename"])) {
          $user->setPictureFilename($params["picture_filename"]);
        }
        if(isset($params["first_name"])) {
          $user->setFirstName($params["first_name"]);
        }
        $user->setName($params["name"]);
        $user->setEmail($params["email"]);
        if(isset($params["first_name"])) {
          $user->setDateOfBirth(new \DateTime($params['date_of_birth']));
        }
        $user->setPhoneNumber($params["phone_number"]);
        $user->setAddress($params["address"]);
        $user->setPostalCode($params["postal_code"]);
        $user->setCity($this->cs->find($params["city"]));
        $user->setBio($params["bio"]);
        if(isset($params["cv_filename"])) {
          $user->setCvFilename($params["cv_filename"]);
        }

        $this->um->updateUser($user);
        return $user;
    }

    /* -------------------------------------------------------------------------
    check if user already exists, given $params["email"]. if not, return updated
    user returned by UserManagerInterface's updateUser function, given $params.
    ------------------------------------------------------------------------- */
    public function createEmployer($params)
    {
        $u = $this->um->findUserByEmail($params["email"]);
        if(!$u) {
            $user = $this->um->createUser();

            $user->setUsername($params["username"]);
            $user->setEmail($params["email"]);
            $user->setEnabled(true);
            $password = $this->encoder->encodePassword($user, $params["password"]);
            $user->setPassword($password);
            $user->removeRole("ROLE_CANDIDATE");
            $user->addRole("ROLE_EMPLOYER");
            $user->setName($params["name"]);
            $user->setAddress($params["address"]);
            $user->setPostalCode($params["postal_code"]);
            $city = $this->cs->findByName($params["city"]);
            if(empty($city)) {
              $city = $this->cs->find(1);
            }
            $user->setCity($city);
            $user->setBio($params["bio"]);

            $this->um->updateUser($user);
            return $user;
        } else {
            return("user already exists...");
        }
    }

    /* -------------------------------------------------------------------------
    autowire UserManagerInterface, UserPasswordEncoderInterface and CityService.
    ------------------------------------------------------------------------- */
    public function __construct(UserManagerInterface $um,
                                UserPasswordEncoderInterface $encoder,
                                CityService $cs)
    {
        $this->um = $um;
        $this->encoder = $encoder;
        $this->cs = $cs;
    }
}
