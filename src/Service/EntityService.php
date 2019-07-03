<?php

namespace App\Service;

class EntityService
{
    private $em;
    protected $rep;

    public function find($id)
    {
      return $this->rep->find($id);
    }

    public function findAll()
    {
      return $this->rep->findAll();
    }

    public function update($entity, $params)
    {
      foreach($params as $key => $val) {
        if(strpos($key, 'date') !== false) {
          $val = new \DateTime($val);
        }
        $setKey = 'set'.ucfirst($key);
        $entity->$setKey($val);
      }
    }

    /*
    public function getFields($entity)
    {
      return $this->em->getClassMetadata($entity)
                      ->reflFields;
    }
    */

    public function __construct($em, $entity) //get the em and entity from child
    {
      $this->em = $em;
      $this->rep = $this->em->getRepository($entity);
    }
}
