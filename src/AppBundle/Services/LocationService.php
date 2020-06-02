<?php

namespace AppBundle\Services;
use AppBundle\Entity\AnnualCostRepository;
use AppBundle\Entity\EnergyPointRepository;
use AppBundle\Entity\LocationRepository;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Created by PhpStorm.
 * User: martz
 * Date: 11/14/15
 * Time: 1:26 PM
 */
class LocationService
{

    protected  $locationRepository;
    protected $energyPointRepository;
    protected $annualCostRepository;

    public function __construct(
        LocationRepository $locationRepository,
        EnergyPointRepository $energyPointRepository,
        AnnualCostRepository $annualCostRepository
    ){
        $this->locationRepository = $locationRepository;
        $this->energyPointRepository = $energyPointRepository;
        $this->annualCostRepository = $annualCostRepository;
    }

    public function countAll($name){
        return $this->locationRepository->countAll($name);
    }

    public function findAll(){
        return $this->locationRepository->findAll();
    }

    public function findByPage($name, $offset, $limit){
        return $this->locationRepository->findByPage($name, $offset, $limit);
    }

    public function saveOrUpdate($uid, $location){

        if($location->getId()==null){
            //Nuevo
            $location->setStatus(true);
            $location->setCreateDate(new \DateTime());
            $location->setCreateUser($uid);

        }else{
            //Edicion
            $location->setWriteDate(new \DateTime());
            $location->setWriteUser($uid);
        }

        $this->locationRepository->saveOrUpdate($location);
    }

    public function delete($uid, $location){
        $location->setStatus(false);
        $location->setWriteDate(new \DateTime());
        $location->setWriteUser($uid);

        //Validar que se deben borrar todas sus dependencias o informar que no se puede borrar.
        $energyPoints = $this->energyPointRepository->findByLocation($location);
        if(sizeof($energyPoints) > 0){
            throw new Exception("No se puede borrar el registro ya que existen puntos energéticos asociados.");
        }

        $annualCosts = $this->annualCostRepository->findByLocation($location);
        if (sizeof($annualCosts) > 0){
            throw new Exception("No se puede borrar el registro ya que existen costos anuales asociados.");
        }

        $this->locationRepository->saveOrUpdate($location);
    }

    public function find($id){
        return $this->locationRepository->find($id);
    }
}