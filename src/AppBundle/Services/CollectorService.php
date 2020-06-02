<?php
/**
 * Created by PhpStorm.
 * User: martz
 * Date: 12/24/15
 * Time: 2:33 PM
 */

namespace AppBundle\Services;

use AppBundle\Entity\CollectorRepository;
use AppBundle\Entity\AssignedCollectorRepository;
use AppBundle\Entity\ScheduleRepository;

class CollectorService
{

    protected $collectorRepository;
    protected $assignedCollectorRepository;
    protected $scheduleRepository;

    public function __construct(
        CollectorRepository $collectorRepository,
        AssignedCollectorRepository $assignedCollectorRepository,
        ScheduleRepository $scheduleRepository
    ){
        $this->collectorRepository = $collectorRepository;
        $this->assignedCollectorRepository = $assignedCollectorRepository;
        $this->scheduleRepository = $scheduleRepository;
    }


    public function find($id){
        return $this->collectorRepository->find($id);
    }

    public function findByCode($code){
        return $this->collectorRepository->findByCode($code);
    }

    public function findCurrentByCode($code){
        return $this->assignedCollectorRepository->findCurrentCollector($code);
    }

    public function findByPage($code,$offset, $limit){
        return $this->collectorRepository->findByPage($code, $offset, $limit);
    }

    public function countAll($code){
        return $this->collectorRepository->countAll($code);
    }

    public function saveOrUpdate($uid, $collector){

        if($collector->getId()==null){
            //Nuevo
            $collector->setStatus(true);
            $collector->setCreateDate(new \DateTime());
            $collector->setCreateUser($uid);

        }else{
            //Edicion
            $collector->setWriteDate(new \DateTime());
            $collector->setWriteUser($uid);
        }

        $this->collectorRepository->saveOrUpdate($collector);
    }

    public function delete($uid, $collector){

        //Busca los schedules
        $schedules = $this->scheduleRepository->findAllByCollector($collector);

        $entityManager = $this->collectorRepository->getEM();

        //Borrar todos los schedules asociados

        foreach($schedules as $schedule){
            $schedule->setStatus(false);
            $schedule->setWriteDate(new \DateTime());
            $schedule->setWriteUser($uid);

            //Borra schedule
            $entityManager->persist($schedule);
        }

        $collector->setStatus(false);
        $collector->setWriteDate(new \DateTime());
        $collector->setWriteUser($uid);

        //Borra collector
        $entityManager->persist($collector);

        //Commit
        $entityManager->flush();
    }
}