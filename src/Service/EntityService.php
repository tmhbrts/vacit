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

    public function findAZ($orderBy)
    {
      return $this->rep->findBy([], [$orderBy => 'ASC']);
    }

    public function findByName($name)
    {
      return $this->rep->createQueryBuilder('q')
                       ->andWhere('q.name = :name')
                       ->setParameter('name', $name)
                       ->getQuery()
                       ->getOneOrNullResult();
    }

    public function remove($id)
    {
      $object = $this->find($id);
      $this->em->remove($object);
      $this->em->flush();
    }

    public function __construct($em, $entity) //get the em and entity from child
    {
      $this->em = $em;
      $this->rep = $this->em->getRepository($entity);
    }
}
