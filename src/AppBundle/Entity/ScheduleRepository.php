<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ScheduleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ScheduleRepository extends EntityRepository
{

    public function findAllByCollector(Collector $collector){
        $queryString = "select e from AppBundle:Schedule e
              where e.status = :status and e.collector = :collector
              order by e.processDate asc ";

        $query = $this->getEntityManager()->createQuery($queryString);
        $query->setParameter("status",true);
        $query->setParameter("collector", $collector);

        return $query->getResult();

    }


    public function findByCollector(Collector $collector, $type, $offset, $limit){
        $queryString = "select e from AppBundle:Schedule e
              where e.status = :status
              and e.collector = :collector
              and e.type = :type
              order by e.processDate asc ";

        $query = $this->getEntityManager()->createQuery($queryString)
            ->setFirstResult($offset)
            ->setMaxResults($limit);
        $query->setParameter("status",true);
        $query->setParameter("collector", $collector);
        $query->setParameter("type", $type);

        return $query->getResult();

    }


    public function countAllByCollector(Collector $collector, $type){

        $queryString = "select count(l) from AppBundle:Schedule l
              where l.status = :status
              and l.collector = :collector
              and l.type = :type";

        $query = $this->getEntityManager()->createQuery($queryString);
        $query->setParameter("status",true);
        $query->setParameter("collector", $collector);
        $query->setParameter("type", $type);

        return $query->getSingleScalarResult();
    }

    public function saveOrUpdate(Schedule $schedule){
        $this->getEntityManager()->persist($schedule);
        $this->getEntityManager()->flush();
    }
}
