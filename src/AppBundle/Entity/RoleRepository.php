<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * RoleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RoleRepository extends EntityRepository
{

    public function getEM(){
        return $this->getEntityManager();
    }

    public function findRoles(User $user){
        $queryString = "select r from Role r where r.users = :user order by r.name asc";
        $query = $this->getEM()->createQuery($queryString);
        $query->setParameter("status",true);
        return $query->getResult();
    }
}
