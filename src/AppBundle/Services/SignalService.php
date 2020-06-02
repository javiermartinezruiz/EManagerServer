<?php
/**
 * Created by PhpStorm.
 * User: martz
 * Date: 12/24/15
 * Time: 10:07 AM
 */

namespace AppBundle\Services;


use AppBundle\Entity\SignalGroupRepository;
use AppBundle\Entity\SignalRepository;

class SignalService
{

    protected $signalRepository;
    protected $signalGroupRepository;

    public function __construct(
        SignalGroupRepository $signalGroupRepository,
        SignalRepository $signalRepository){
        $this->signalRepository = $signalRepository;
        $this->signalGroupRepository = $signalGroupRepository;
    }

    public function saveOrUpdate($uid, $signalGroup, $signals){

        //Obtiene el Entity Manager
        $em = $this->signalGroupRepository->getEM();

        //Incluye los datos faltantes
        $signalGroup->setStatus(true);
        $signalGroup->setCreateDate(new \DateTime());
        $signalGroup->setCreateUser($uid);

        //Guarda el grupo sin commit
        $em->persist($signalGroup);

        //Guarda el detalle
        foreach($signals as $signal){
            $signal->setStatus(true);
            $signal->setCreateDate(new \DateTime());
            $signal->setCreateUser($uid);
            $signal->setSignalGroup($signalGroup);
            $em->persist($signal);
        }

        //Commit
        $em->flush();

    }

    public function find($id){
        return $this->signalGroupRepository->find($id);
    }


}