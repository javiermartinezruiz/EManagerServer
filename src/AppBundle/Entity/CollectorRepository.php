<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Collector;

/**
 * CollectorRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CollectorRepository extends EntityRepository{

    public function getEM(){
        return $this->getEntityManager();
    }

    public function findByCode($code){
        $query = $this->_em->createQuery('
            SELECT d from AppBundle:Collector d
            where d.status = :status
            and d.code=:code')
            ->setParameter('status', true)
            ->setParameter('code', $code);
        if($query->getResult() != null){
            return $query->getResult()[0];
        }
        return null;
    }

    public function findByPage($code, $offset, $limit){

        $queryString = "select l from AppBundle:Collector l where l.status = :status";
        if($code!=null && $code!=''){
            $queryString = $queryString." and l.code like :code ";
        }

        $queryString = $queryString." order by l.code asc ";

        $query = $this->getEM()->createQuery($queryString)
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        $query->setParameter("status",true);

        if($code!=null && $code != ""){
            $query->setParameter("code","%".$code."%");
        }

        return $query->getResult();

    }

    public function countAll($code){

        $queryString = "select count(l) from AppBundle:Collector l where l.status = :status ";
        if($code!=null && $code!=''){
            $queryString = $queryString." and l.code like :code ";
        }

        $query = $this->getEM()->createQuery($queryString)
            ->setParameter("status",true);

        if($code!=null && $code != ""){
            $query->setParameter("code","%".$code."%");
        }

        return $query->getSingleScalarResult();
    }

    public function saveOrUpdate(Collector $collector){
        $this->getEntityManager()->persist($collector);
        $this->getEntityManager()->flush();
    }
}
