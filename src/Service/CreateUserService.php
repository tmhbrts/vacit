<?php

namespace App\Service;

use App\Entity\City;
use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateUserService
{
  private $em;
  private $um;
  private $encoder;

  public function __construct(EntityManagerInterface $em,
                              UserManagerInterface $um,
                              UserPasswordEncoderInterface $encoder)
  {
    $this->em = $em;
    $this->um = $um;
    $this->encoder = $encoder;
  }

  public function createUser($params)
  {
    $u = $this->um->findUserByEmail($params["email"]);
    if(!$u) {
      $user = $this->um->createUser();

      $user->setUsername($params["username"]);
      $user->setEmail($params["email"]);
      $user->setEnabled(true);
      $password = $this->encoder->encodePassword($user, $params["password"]);
      $user->setPassword($password);
      $user->addRole($params["role"]);
      $user->setName($params["name"]);
      $user->setAddress($params["address"]);
      $user->setPostalCode($params["postal_code"]);

      $cityRepository = $this->em->getRepository(City::class);
      $city = $cityRepository->findCity($params["city"]);
      if(empty($city)) {
        $city = $cityRepository->find(1);
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
