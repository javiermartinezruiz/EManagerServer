<?php
/**
 * Created by PhpStorm.
 * User: martz
 * Date: 11/14/15
 * Time: 1:07 PM
 */

namespace AppBundle\Controller;

use AppBundle\Form\Type\LocationType;
use AppBundle\Entity\Location;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LocationsController extends Controller
{

    /**
     * @Route("/admin/locations/{page}", name="list_locations", defaults={"page" = 1}, requirements={"page"="\d+"})
     */
    public function showLocationsAction(Request $request, $page){

        //Getting logger
        $logger = $this->get('logger');

        //$json = '{"data":{"code":123, "phases": {"1":{"vol":10}} }}';
        //$deco = json_decode($json, true);
        //$logger->info($deco["data"]["phases"]["1"]["vol"]);

        $logger->info("Page is ".$page);

        $defaultData = array();
        $form = $this->createFormBuilder($defaultData)
            ->add('name', 'text')
            ->getForm();

        $form->handleRequest($request);

        $name = "";
        if ($form->isValid()) {
            $data = $form->getData();
            $name = $data["name"];
        }

        //Getting services
        $locationService = $this->get('location_service');
        $locations = $locationService->findByPage($name, ($page-1)*5, 5);

        $count = $locationService->countAll($name);
        //$logger->info("Count es ".$count.", ".($count/2).", ".(($count/2)%2).", FMOD=".fmod(($count / 10), 2.0));

        if($count<=5){
            $max = 1;
        }else {
            if (fmod(($count / 2), 5) == 0) {
                $max = floor($count / 5);
            } else {
                $max = floor($count / 5) + 1;
            }
        }

        return $this->render('admin/location/layout.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'locations' => $locations,
            'max'=>$max,
            'current_page'=>$page,
            'form'=>$form->createView(),
            'message'=>'',
            'error'=>'',
        ));
    }


    /**
     * @Route("/admin/locations/new", name="new_location")
     */
    public function addLocationAction(Request $request){
        //Getting logger
        $logger = $this->get('logger');

        //Getting authenticated user
        $uid = $this->get('security.context')->getToken()->getUser();

        $type = "NEW";

        //Getting service
        $locationService = $this->get('location_service');

        $location = new Location();
        $form = $this->createForm(new LocationType(), $location);

        //Handling request
        $form->handleRequest($request);

        $message = '';

        if ($form->isValid()) {
            $logger->info("Valid form! ");

            if($message=='') {
                try {
                    $locationService->saveOrUpdate($uid->getUsername(), $location);
                    $message = 'SUCCESS';
                } catch (Exception $e) {
                    $message = 'ERROR';
                }
            }

        }else{
            $logger->info("Is not valid! ");
        }


        return $this->render('admin/location/form.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'message' => $message,
            'type' => $type,
            'form'=>$form->createView(),
            'message'=>$message,
            'error'=>'',
        ));

    }

    /**
     * @Route("/admin/locations/edit/{id}", name="edit_location",requirements={"id"="\d+"})
     */
    public function editLocationAction(Request $request, $id){
        //Getting logger
        $logger = $this->get('logger');
        $type = "OLD";

        //Getting authenticated user
        $uid = $this->get('security.context')->getToken()->getUser();

        //Getting service
        $locationService = $this->get('location_service');

        $location = $locationService->find($id);
        $logger->info($location->getName().", ".$id);


        $form = $this->createForm(new LocationType(), $location);

        //Handling request
        $form->handleRequest($request);

        $message = '';

        if ($form->isValid()) {
            $logger->info("Valid form! ");

            if(trim($location->getName())==""){
                $message = "ERROR";
                $detailedMessage = "Verifique el nombre ingresado. ";
            }

            if($message=='') {
                try {
                    $locationService->saveOrUpdate($uid->getUsername(), $location);
                    $message = 'SUCCESS';
                } catch (Exception $e) {
                    $message = 'ERROR';
                }
            }
        }else{
            $logger->info("Is not valid! ");
        }


        return $this->render('admin/location/form.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'message' => $message,
            'type' => $type,
            'form'=>$form->createView(),
            'message'=>$message,
            'error'=>'',
        ));

    }

    /**
     * @Route("/admin/locations/delete/{id}/{name}", name="delete_location", defaults={"name" = null})
     */
    public function deleteLocation(Request $request, $id, $name){
        //Getting logger
        $logger = $this->get('logger');
        $logger->info("Borrando ubicacion...");

        //Getting authenticated user
        $uid = $this->get('security.context')->getToken()->getUser();

        //Getting service
        $locationService = $this->get('location_service');

        $location = $locationService->find($id);

        $error = '';
        if($location!=null){
            try{
                $locationService->delete($uid->getUsername(), $location);
            }catch (Exception $e){
                $error = $e->getMessage();
            }
        }

        $locations = $locationService->findByPage($name, 0, 5);
        $count = $locationService->countAll($name);

        $defaultData = array();
        $form = $this->createFormBuilder($defaultData)
            ->add('name', 'text')
            ->getForm();

     //   $form->handleRequest($request);
     //   $name = "";
     //   if ($form->isValid()) {
     //       $data = $form->getData();
     //       $name = $data["name"];
     //   }

        if($count<=5){
            $max = 1;
        }else {
            if (fmod(($count / 2), 5) == 0) {
                $max = floor($count / 5);
            } else {
                $max = floor($count / 5) + 1;
            }
        }

        return $this->render('admin/location/list.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'locations' => $locations,
            'max'=>$max,
            'current_page'=>1,
            'form'=>$form->createView(),
            'error'=>$error,
        ));

    }

}