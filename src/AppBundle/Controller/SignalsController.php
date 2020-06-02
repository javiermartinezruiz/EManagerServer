<?php
/**
 * Created by PhpStorm.
 * User: martz
 * Date: 12/23/15
 * Time: 7:30 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Signal;
use AppBundle\Entity\SignalGroup;
use AppBundle\Form\Type\LocationType;
use AppBundle\Entity\Location;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class SignalsController extends Controller
{
    /**
     *
     * @return array
     * @View()
     */
    public function getLocationsAction(){
        //Getting services
        $locationService = $this->get('location_service');
        $locations = $locationService->findByPage("", 0*5, 5);

        return array('locations'=>$locations);
    }

    /**
     *
     * @param $id
     * @return array
     * @View()
     */
    public function getLocationAction($id){
        $locationService = $this->get('location_service');
        $location = $locationService->find($id);
        if(!$location instanceof Location){
            throw new NotFoundHttpException("Location not found");
        }
        return array('location'=>$location);
    }


    /**
     *
     * @param $id
     * @return array
     * @View()
     */
    public function getGroupAction($id){
        $signalService = $this->get('signal_service');
        $signalGroup = $signalService->find($id);
        if(!$signalGroup instanceof SignalGroup){
            throw new NotFoundHttpException("SignalGroup not found");
        }
        return array('signal_group'=>$signalGroup);
    }


    /**
     * @param Request $request
     * @return Response
     */
    public function postGroupAction(Request $request){

        $signalService = $this->get('signal_service');
        $collectorService = $this->get('collector_service');

        $undecoded = $request->getContent();
        $decoded = json_decode($undecoded, true);

        //Obteniendo codigo de colector
        $data = $decoded["data"];
        $collectorId = $data["collector"];

        //Obteniendo informacion de punto energetico
        $assignedCollector = $collectorService->findCurrentByCode($collectorId);
        if($assignedCollector==null){
            $response = new Response();
            $response->setStatusCode(400);
            return $response;
        }

        //Obteniendo la fecha de coleccion
        $mil = $data["date"];
        $seconds = $mil / 1000;
        $collectionDate = date("d/m/Y H:i:s", $seconds);
        $timeStamp = \DateTime::createFromFormat('d/m/Y H:i:s', $collectionDate);

        //Obteniendo frecuencia
        $frequency = $data["frequency"]["value"];

        //Obteniendo desbalance de corriente
        $currentUnbalance = $data["current_unbalance"];

        //Obteniendo desbalance de voltage
        $voltageUnbalance = $data["voltage_unbalance"];

        //Creando cabecera
        $signalGroup = new SignalGroup();
        $signalGroup->setCollectionDate($timeStamp);
        $signalGroup->setFrequency($frequency);
        $signalGroup->setCurrentUnbalance($currentUnbalance);
        $signalGroup->setVoltageUnbalance($voltageUnbalance);

        //Obteniendo fases
        $phases = $data["phases"];

        $theSignals = array();
        foreach($phases as $phase=>$value){

            //Creando signal
            $signal = new Signal();
            $signal->setPhase($phase);
            $signal->setVoltage($value["voltage"]);
            $signal->setCurrent($value["current"]);
            $signal->setActivePower($value["active_power"]);
            $signal->setReactivePower($value["reactive_power"]);
            $signal->setApparentPower($value["apparent_power"]);
            $signal->setPowerFactor($value["power_factor"]);
            $signal->setVoltageThd($value["voltage_thd"]);
            $signal->setCurrentThd($value["current_thd"]);
            $signal->setCrestFactor($value["crest_factor"]);
            $signal->setConsumedEnergy($value["consumed_energy"]);
            $signal->setDeliveredEnergy($value["delivered_energy"]);
            $signal->setPhaseAngle($value["phase_angle"]);
            $signal->setEnergyPoint($assignedCollector->getEnergyPoint());

            array_push($theSignals, $signal);

        }

        //Guardando informacion
        $signalService->saveOrUpdate("rest", $signalGroup, $theSignals);

        $response = new Response();
        $response->setStatusCode(201);
        $response->headers->set('Location',
            $this->generateUrl(
                'get_group', array('id' => $signalGroup->getId()),
                true // absolute
            )
        );
        return $response;

    }


    /**
     * @param $request
     */
    public function postLocationsAction(Request $request){

        //Getting service
        $locationService = $this->get('location_service');

        $location = new Location();
        $form = $this->createForm(new LocationType(), $location);

        //Handling request
        $form->handleRequest($request);

        if ($form->isValid()) {
            $locationService->saveOrUpdate("rest", $location);

            $response = new Response();
            $response->setStatusCode(201);
            $response->headers->set('Location',
                $this->generateUrl(
                    'get_location', array('id' => $location->getId()),
                    true // absolute
                )
            );

            return $response;

        }

        $response = new Response();
        $response->setStatusCode(400);
        return $response;
    }

    /**
     * @param $request
     * @param $location
     */
    public function putLocationsAction(Request $request, Location $location){
        //Getting service
        $locationService = $this->get('location_service');

        $form = $this->createForm(new LocationType(), $location, array("method"=>'PUT') );

        //Handling request
        $form->handleRequest($request);

        if ($form->isValid()) {
            $locationService->saveOrUpdate("rest", $location);

            $response = new Response();
            $response->setStatusCode(204);
            $response->headers->set('Location',
                $this->generateUrl(
                    'get_location', array('id' => $location->getId()),
                    true // absolute
                )
            );

            return $response;

        }

        $response = new Response();
        $response->setStatusCode(400);
        return $response;
    }

}