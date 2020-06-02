<?php
/**
 * Created by PhpStorm.
 * User: martz
 * Date: 1/6/16
 * Time: 9:36 PM
 */

namespace AppBundle\Services;


use AppBundle\Entity\EnergyPointRepository;
use AppBundle\Entity\AssignedCollectorRepository;
use AppBundle\Entity\Location;
use AppBundle\Entity\SignalRepository;
use Symfony\Component\Config\Definition\Exception\Exception;

class EnergyPointService
{
    protected  $energyPointRepository;
    protected $assignedCollectorRepository;
    protected $signalRepository;

    public function __construct(
        EnergyPointRepository $energyPointRepository,
        AssignedCollectorRepository $assignedCollectorRepository,
        SignalRepository $signalRepository
    ){
        $this->energyPointRepository = $energyPointRepository;
        $this->assignedCollectorRepository = $assignedCollectorRepository;
        $this->signalRepository = $signalRepository;
    }

    public function countAll($code){
        return $this->energyPointRepository->countAll($code);
    }

    public function findByPage($code, $offset, $limit){
        return $this->energyPointRepository->findByPage($code, $offset, $limit);
    }

    public function saveOrUpdate($uid, $energyPoint){

        if($energyPoint->getId()==null){
            //Nuevo
            $energyPoint->setStatus(true);
            $energyPoint->setCreateDate(new \DateTime());
            $energyPoint->setCreateUser($uid);

        }else{
            //Edicion
            $energyPoint->setWriteDate(new \DateTime());
            $energyPoint->setWriteUser($uid);
        }

        $this->energyPointRepository->saveOrUpdate($energyPoint);
    }

    public function delete($uid, $energyPoint){
        $energyPoint->setStatus(false);
        $energyPoint->setWriteDate(new \DateTime());
        $energyPoint->setWriteUser($uid);

        //Validar que se deben borrar todas sus dependencias o informar que no se puede borrar.
        //Buscar energy units asociados

        $assignedCollectors = $this->assignedCollectorRepository->findByEnergyPoint($energyPoint);
        if(sizeof($assignedCollectors) > 0){
            throw new Exception("No se puede borrar el registro ya que existen colectores asociados.");
        }

        $countEnergyPoints = $this->signalRepository->countByEnergyPoint($energyPoint);
        if($countEnergyPoints > 0){
            throw new Exception("No se puede borrar el registro ya que existen lecturas asociadas.");
        }

        $this->energyPointRepository->saveOrUpdate($energyPoint);
    }

    public function find($id){
        return $this->energyPointRepository->find($id);
    }


}