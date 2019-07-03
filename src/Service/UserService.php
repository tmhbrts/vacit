<?php

namespace App\Service;

use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Service\CityService;

class UserService
{
  private $um;
  private $encoder;
  private $cs;

  public function __construct(UserManagerInterface $um,
                              UserPasswordEncoderInterface $encoder,
                              CityService $cs)
  {
    $this->um = $um;
    $this->encoder = $encoder;
    $this->cs = $cs;
  }

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
      $city = $this->cs->findCity($params["city"]);
      if(empty($city)) {
        $city = $this->cs->find(1);
      }
      $user->setCity($city);
      $user->setBio($params["bio"]);

      $this->um->updateUser($user);
      return($user);
    } else {
      return("user already exists...");
    }
  }
}
