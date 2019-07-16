<?php

namespace App\Service;

/* -----------------------------------------------------------------------------
parent class for all other entity services
----------------------------------------------------------------------------- */
class EntityService
{
    private $em; //to contain the EntityManagerInterface, given by child Service
    protected $rep; //to contain the Repository of the Entity given by child Service

    /* -------------------------------------------------------------------------
    return an object (Entity instance) returned by the Repository's built-in
    find function, given $id.
    ------------------------------------------------------------------------- */
    public function find($id)
    {
        return $this->rep->find($id);
    }

    /* -------------------------------------------------------------------------
    return an array of objects (Entity instance) returned by the Repository's
    built-in findAll function, given $id.
    ------------------------------------------------------------------------- */
    public function findAll()
    {
        return $this->rep->findAll();
    }

    /* -------------------------------------------------------------------------
    return an array of objects (Entity instance) sorted Alphabetically from A to
    Z, returned by the Repository's built-in findAll function, given the field
    name $orderBy
    ------------------------------------------------------------------------- */
    public function findAZ($orderBy)
    {
        return $this->rep->findBy([], [$orderBy => 'ASC']);
    }

    /* -------------------------------------------------------------------------
    return an array of objects (Entity instance) sorted Alphabetically from A to
    Z, returned by the Repository's built-in findAll function, given the field
    name $orderBy
    ------------------------------------------------------------------------- */
    public function findByName($name)
    {
        return $this->rep->createQueryBuilder('q')
                         ->andWhere('q.name = :name')
                         ->setParameter('name', $name)
                         ->getQuery()
                         ->getOneOrNullResult();
    }

    /* -------------------------------------------------------------------------
    use $em to remove the object returned by own find function, given id.
    ------------------------------------------------------------------------- */
    public function remove($id)
    {
        $object = $this->find($id);
        $this->em->remove($object);
        $this->em->flush();
    }

    /* -------------------------------------------------------------------------
    set own $em. set own $rep using repository of given $entity
    ------------------------------------------------------------------------- */
    public function __construct($em, $entity) //get the em and entity from child
    {
        $this->em = $em;
        $this->rep = $this->em->getRepository($entity);
    }
}
