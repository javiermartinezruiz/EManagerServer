<?php
/**
 * Created by PhpStorm.
 * User: martz
 * Date: 2/15/16
 * Time: 9:44 PM
 */

namespace AppBundle\Services;


use AppBundle\Entity\ScheduleRepository;

class ScheduleService
{
    protected $scheduleRepository;

    public function __construct(
        ScheduleRepository $scheduleRepository
    ){
        $this->scheduleRepository = $scheduleRepository;
    }

    public function findCollectionScheduleByCollector($collector, $offset, $limit){
        return $this->scheduleRepository->findByCollector($collector, 'COLLECTION_DATA', $offset, $limit);
    }

    public function countAllCollectionScheduleByCollector($collector){
        return $this->scheduleRepository->countAllByCollector($collector, 'COLLECTION_DATA');
    }

    public function findSendingDataScheduleByCollector($collector, $offset, $limit){
        return $this->scheduleRepository->findByCollector($collector, 'SENDING_DATA', $offset, $limit);
    }

    public function countAllSendingDataScheduleByCollector($collector){
        return $this->scheduleRepository->countAllByCollector($collector, 'SENDING_DATA');
    }

    public function findSendingEventsScheduleByCollector($collector, $offset, $limit){
        return $this->scheduleRepository->findByCollector($collector, 'SENDING_EVENTS', $offset, $limit);
    }

    public function countAllSendingEventsScheduleByCollector($collector){
        return $this->scheduleRepository->countAllByCollector($collector, 'SENDING_EVENTS');
    }

    public function find($id){
        return $this->scheduleRepository->find($id);
    }


    public function delete($uid, $schedule){
        $schedule->setStatus(false);
        $schedule->setWriteDate(new \DateTime());
        $schedule->setWriteUser($uid);
        $this->scheduleRepository->saveOrUpdate($schedule);
    }



}