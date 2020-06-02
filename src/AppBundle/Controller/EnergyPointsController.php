<?php
/**
 * Created by PhpStorm.
 * User: martz
 * Date: 1/6/16
 * Time: 9:25 PM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\EnergyPoint;
use AppBundle\Form\Type\EnergyPointType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EnergyPointsController extends Controller
{

    /**
     * @Route("/admin/energypoints/{page}", name="list_energy_points", defaults={"page" = 1}, requirements={"page"="\d+"})
     */
    public function showEnergyPointsAction(Request $request, $page){

        //Getting logger
        $logger = $this->get('logger');

        $logger->info("Page is ".$page);

        $defaultData = array();
        $form = $this->createFormBuilder($defaultData)
            ->add('code', 'text')
            ->getForm();

        $form->handleRequest($request);

        $code = "";
        if ($form->isValid()) {
            $data = $form->getData();
            $code = $data["code"];
        }

        //Getting services
        $energyPointService = $this->get('energypoint_service');
        $points = $energyPointService->findByPage($code, ($page-1)*5, 5);

        $count = $energyPointService->countAll($code);
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

        return $this->render('admin/energy_point/layout.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'points' => $points,
            'max'=>$max,
            'current_page'=>$page,
            'form'=>$form->createView(),
            'error'=>'',
        ));
    }


    /**
     * @Route("/admin/energypoints/new", name="new_energy_point")
     */
    public function addEnergyPointAction(Request $request){
        //Getting logger
        $logger = $this->get('logger');

        $uid = $this->get('security.context')->getToken()->getUser();

        $type = "NEW";

        //Getting service
        $energyPointService = $this->get('energypoint_service');

        $energyPoint = new EnergyPoint();
        $form = $this->createForm(new EnergyPointType(), $energyPoint);

        //Handling request
        $form->handleRequest($request);

        $message = '';

        if ($form->isValid()) {
            $logger->info("Valid form! ");

            if($message=='') {
                try {
                    $energyPointService->saveOrUpdate($uid->getUsername(), $energyPoint);
                    $message = 'SUCCESS';
                } catch (Exception $e) {
                    $message = 'ERROR';
                }
            }

        }else{
            $logger->info("Is not valid! ");
        }


        return $this->render('admin/energy_point/form.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'message' => $message,
            'type' => $type,
            'form'=>$form->createView(),
            'message'=>$message,
            'error'=>'',
        ));

    }

    /**
     * @Route("/admin/energypoints/edit/{id}", name="edit_energy_point",requirements={"id"="\d+"})
     */
    public function editEnergyPointAction(Request $request, $id){
        //Getting logger
        $logger = $this->get('logger');
        $type = "OLD";

        //Getting authenticated user
        $uid = $this->get('security.context')->getToken()->getUser();

        //Getting service
        $energyPointService = $this->get('energypoint_service');

        //Getting registered energy point
        $energyPoint = $energyPointService->find($id);

        $form = $this->createForm(new EnergyPointType(), $energyPoint);

        //Handling request
        $form->handleRequest($request);

        $message = '';

        if ($form->isValid()) {
            $logger->info("Valid form! ");

            if(trim($energyPoint->getCode())==""){
                $message = "ERROR";
                $detailedMessage = "Verifique el nombre ingresado. ";
            }

            if($message=='') {
                try {
                    $energyPointService->saveOrUpdate($uid->getUsername(), $energyPoint);
                    $message = 'SUCCESS';
                } catch (Exception $e) {
                    $message = 'ERROR';
                }
            }
        }else{
            $logger->info("Is not valid! ");
        }

        return $this->render('admin/energy_point/form.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'message' => $message,
            'type' => $type,
            'form'=>$form->createView(),
            'message'=>$message,
            'error'=>'',
        ));

    }

    /**
     * @Route("/admin/energypoints/delete/{id}/{code}", name="delete_energy_point", defaults={"code" = null})
     */
    public function deleteEnergyPointAction(Request $request, $id, $code){

        //Getting logger
        $logger = $this->get('logger');
        $logger->info("Borrando energy point...");

        //Getting authenticated user
        $uid = $this->get('security.context')->getToken()->getUser();

        //Getting service
        $energyPointService = $this->get('energypoint_service');

        $error = '';
        $energyPoint = $energyPointService->find($id);
        if($energyPoint!=null){
            try{
                $energyPointService->delete($uid->getUsername(), $energyPoint);
            }catch (Exception $e){
                $error = $e->getMessage();
            }
        }

        $logger->info("Code=".$code);
        $energyPoints = $energyPointService->findByPage($code, 0, 5);

        $count = $energyPointService->countAll($code);

        $defaultData = array();
        $form = $this->createFormBuilder($defaultData)
            ->add('code', 'text')
            ->getForm();

        if($count<=5){
            $max = 1;
        }else {
            if (fmod(($count / 2), 5) == 0) {
                $max = floor($count / 5);
            } else {
                $max = floor($count / 5) + 1;
            }
        }

        return $this->render('admin/energy_point/list.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'points' => $energyPoints,
            'max'=>$max,
            'current_page'=>1,
            'form'=>$form->createView(),
            'error'=>$error,

        ));

    }

}