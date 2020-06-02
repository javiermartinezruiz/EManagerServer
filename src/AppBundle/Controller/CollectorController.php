<?php
/**
 * Created by PhpStorm.
 * User: martz
 * Date: 2/15/16
 * Time: 8:09 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Collector;
use AppBundle\Form\Type\CollectorType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CollectorController extends Controller
{

    /**
     * @Route("/admin/collectors/{page}", name="list_collectors", defaults={"page" = 1}, requirements={"page"="\d+"}, options={"expose"=true})
     */
    public function showCollectorsAction(Request $request, $page){

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
        $collectorService = $this->get('collector_service');
        $records = $collectorService->findByPage($code, ($page-1)*5, 5);

        $count = $collectorService->countAll($code);
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

        return $this->render('admin/collector/layout.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'records' => $records,
            'max'=>$max,
            'current_page'=>$page,
            'form'=>$form->createView(),
            'error'=>'',
        ));
    }

    /**
     * @Route("/admin/collectors/new", name="new_collector")
     */
    public function addCollectorAction(Request $request){
        //Getting logger
        $logger = $this->get('logger');

        $uid = $this->get('security.context')->getToken()->getUser();

        $type = "NEW";

        //Getting service
        $collectorService = $this->get('collector_service');


        $collector = new Collector();
        $form = $this->createForm(new CollectorType(), $collector);

        //Handling request
        $form->handleRequest($request);

        $message = '';

        if ($form->isValid()) {
            $logger->info("Valid form! ");

            if($message=='') {
                try {
                    $collectorService->saveOrUpdate($uid->getUsername(), $collector);
                    $message = 'SUCCESS';
                } catch (Exception $e) {
                    $message = 'ERROR';
                }
            }

        }else{
            $logger->info("Is not valid! ");
        }


        return $this->render('admin/collector/form.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'message' => $message,
            'type' => $type,
            'form'=>$form->createView(),
            'message'=>$message,
            'error'=>'',
            'collect_hours'=>array(),
            'send_data_hours'=>array(),
            'send_events_hours'=>array(),
        ));

    }


    /**
     * @Route("/admin/collectors/edit/{id}", name="edit_collector",requirements={"id"="\d+"})
     */
    public function editCollectorAction(Request $request, $id){
        //Getting logger
        $logger = $this->get('logger');
        $type = "OLD";

        //Getting authenticated user
        $uid = $this->get('security.context')->getToken()->getUser();

        //Getting service
        $collectorService = $this->get('collector_service');

        //Getting registered collector
        $collector = $collectorService->find($id);

        //Creating form
        $form = $this->createForm(new CollectorType(), $collector);

        //Handling request
        $form->handleRequest($request);

        $message = '';

        if ($form->isValid()) {
            $logger->info("Valid form! ");

            if(trim($collector->getCode())==""){
                $message = "ERROR";
                $detailedMessage = "Verifique el nombre ingresado. ";
            }

            if($message=='') {
                try {
                    $collectorService->saveOrUpdate($uid->getUsername(), $collector);
                    $message = 'SUCCESS';
                } catch (Exception $e) {
                    $message = 'ERROR';
                }
            }
        }else{
            $logger->info("Is not valid! ");
        }

        return $this->render('admin/collector/form.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'message' => $message,
            'type' => $type,
            'form'=>$form->createView(),
            'message'=>$message,
            'error'=>''
        ));

    }

    /**
     * @Route("/admin/collectors/delete/{id}/{code}", name="delete_collector", defaults={"code" = null})
     */
    public function deleteCollectorAction(Request $request, $id, $code){

        //Getting logger
        $logger = $this->get('logger');
        $logger->info("Borrando collector...");

        //Getting authenticated user
        $uid = $this->get('security.context')->getToken()->getUser();

        //Getting service
        $collectorService = $this->get('collector_service');

        $error = '';
        $collector = $collectorService->find($id);
        if($collector!=null){
            try{
                $collectorService->delete($uid->getUsername(), $collector);
            }catch (Exception $e){
                $error = $e->getMessage();
            }
        }

        $logger->info("Code=".$code);
        $collectors = $collectorService->findByPage($code, 0, 5);

        $count = $collectorService->countAll($code);

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

        return $this->render('admin/collector/list.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'records' => $collectors,
            'max'=>$max,
            'current_page'=>1,
            'form'=>$form->createView(),
            'error'=>$error,
            'collect_hours'=>array(),
            'send_data_hours'=>array(),
            'send_events_hours'=>array(),
        ));

    }

    /**
     * @Route("/admin/collectors/collectiondataschedules/delete/{id}/{collector}", name="delete_collection_schedule", options={"expose"=true})
     */
    public function deleteCollectionDataScheduleAction(Request $request, $id, $collector){
        //Getting logger
        $logger = $this->get('logger');
        $logger->info("Borrando schedule...");

        //Getting authenticated user
        $uid = $this->get('security.context')->getToken()->getUser();

        //Getting service
        $scheduleService = $this->get('schedule_service');

        $error = '';
        $schedule = $scheduleService->find($id);
        if($schedule!=null){
            try{
                $scheduleService->delete($uid->getUsername(), $schedule);
            }catch (Exception $e){
                $error = $e->getMessage();
            }
        }

        $collectionSchedule = $scheduleService->findCollectionScheduleByCollector($schedule->getCollector(), 0*5, 5);
        $countCollection = $scheduleService->countAllCollectionScheduleByCollector($schedule->getCollector());
        if($countCollection<=5){
            $maxCollection = 1;
        }else {
            if (fmod(($countCollection / 2), 5) == 0) {
                $maxCollection = floor($countCollection / 5);
            } else {
                $maxCollection = floor($countCollection / 5) + 1;
            }
        }


        return $this->render('admin/collector/form_collect_data.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'records'=>$collectionSchedule,
            'max'=>$maxCollection,
            'current_page'=>1,
            'collector_code'=>$collector,
        ));
    }

    /**
     * @Route("/admin/collectors/sendingdataschedules/delete/{id}/{collector}", name="delete_sendingdata_schedule", options={"expose"=true})
     */
    public function deleteSendingDataScheduleAction(Request $request, $id, $collector){
        //Getting logger
        $logger = $this->get('logger');
        $logger->info("Borrando schedule...");

        //Getting authenticated user
        $uid = $this->get('security.context')->getToken()->getUser();

        //Getting service
        $scheduleService = $this->get('schedule_service');

        $error = '';
        $schedule = $scheduleService->find($id);
        if($schedule!=null){
            try{
                $scheduleService->delete($uid->getUsername(), $schedule);
            }catch (Exception $e){
                $error = $e->getMessage();
            }
        }

        $sendingDataSchedule = $scheduleService->findSendingDataScheduleByCollector($schedule->getCollector(), 0*5, 5);
        $countCollection = $scheduleService->countAllSendingDataScheduleByCollector($schedule->getCollector());
        if($countCollection<=5){
            $maxCollection = 1;
        }else {
            if (fmod(($countCollection / 2), 5) == 0) {
                $maxCollection = floor($countCollection / 5);
            } else {
                $maxCollection = floor($countCollection / 5) + 1;
            }
        }


        return $this->render('admin/collector/form_send_data.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'records'=>$sendingDataSchedule,
            'max'=>$maxCollection,
            'current_page'=>1,
            'collector_code'=>$collector,
        ));
    }


    /**
     * @Route("/admin/collectors/sendingeventsschedules/delete/{id}/{collector}", name="delete_sendingevents_schedule", options={"expose"=true})
     */
    public function deleteSendingEventsScheduleAction(Request $request, $id, $collector){
        //Getting logger
        $logger = $this->get('logger');
        $logger->info("Borrando schedule...");

        //Getting authenticated user
        $uid = $this->get('security.context')->getToken()->getUser();

        //Getting service
        $scheduleService = $this->get('schedule_service');

        $error = '';
        $schedule = $scheduleService->find($id);
        if($schedule!=null){
            try{
                $scheduleService->delete($uid->getUsername(), $schedule);
            }catch (Exception $e){
                $error = $e->getMessage();
            }
        }

        $sendingEventsSchedule = $scheduleService->findSendingEventsScheduleByCollector($schedule->getCollector(), 0*5, 5);
        $count = $scheduleService->countAllSendingEventsScheduleByCollector($schedule->getCollector());
        if($count<=5){
            $maxCollection = 1;
        }else {
            if (fmod(($count / 2), 5) == 0) {
                $maxCollection = floor($count / 5);
            } else {
                $maxCollection = floor($count / 5) + 1;
            }
        }


        return $this->render('admin/collector/form_send_events.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'records'=>$sendingEventsSchedule,
            'max'=>$maxCollection,
            'current_page'=>1,
            'collector_code'=>$collector,
        ));
    }


    /**
     *  @Route("/admin/collectors/collectiondataschedules/{collector}/{page}", name="load_collection_schedule", defaults={"page" = 1}, options={"expose"=true})
     */
    public function loadCollectionScheduleAction(Request $request, $collector, $page){

        //Getting logger
        $logger = $this->get('logger');

        //Getting service
        $collectorService = $this->get('collector_service');
        $scheduleService = $this->get('schedule_service');

        //Getting registered collector
        $coll = $collectorService->findByCode($collector);

        if($coll!=null) {
            //Load schedules
            $collectionSchedule = $scheduleService->findCollectionScheduleByCollector($coll, ($page - 1) * 5, 5);
            $countCollection = $scheduleService->countAllCollectionScheduleByCollector($coll);
            if ($countCollection <= 5) {
                $maxCollection = 1;
            } else {
                if (fmod(($countCollection / 2), 5) == 0) {
                    $maxCollection = floor($countCollection / 5);
                } else {
                    $maxCollection = floor($countCollection / 5) + 1;
                }
            }

        }


        //$sendDataSchedule = $scheduleService->findSendDataScheduleByCollector($coll, ($page-1)*5, 5);
        //$sendEventsSchedule = $scheduleService->findSendEventsScheduleByCollector($coll, ($page-1)*5, 5);

        return $this->render('admin/collector/form_collect_data.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'records' => $collectionSchedule,
            'max'=>$maxCollection,
            'current_page'=>$page,
            'collector_code'=>$collector,
        ));

    }


    /**
     *  @Route("/admin/collectors/sendingdataschedules/{collector}/{page}", name="load_sendingdata_schedule", defaults={"page" = 1}, options={"expose"=true})
     */
    public function loadSendingDataScheduleAction(Request $request, $collector, $page){

        //Getting logger
        $logger = $this->get('logger');

        //Getting service
        $collectorService = $this->get('collector_service');
        $scheduleService = $this->get('schedule_service');

        //Getting registered collector
        $coll = $collectorService->findByCode($collector);

        if($coll!=null) {
            //Load schedules
            $sendingDataSchedule = $scheduleService->findSendingDataScheduleByCollector($coll, ($page - 1) * 5, 5);
            $countCollection = $scheduleService->countAllSendingDataScheduleByCollector($coll);
            if ($countCollection <= 5) {
                $maxCollection = 1;
            } else {
                if (fmod(($countCollection / 2), 5) == 0) {
                    $maxCollection = floor($countCollection / 5);
                } else {
                    $maxCollection = floor($countCollection / 5) + 1;
                }
            }

        }

        //$sendEventsSchedule = $scheduleService->findSendEventsScheduleByCollector($coll, ($page-1)*5, 5);

        return $this->render('admin/collector/form_send_data.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'records' => $sendingDataSchedule,
            'max'=>$maxCollection,
            'current_page'=>$page,
            'collector_code'=>$collector,
        ));

    }


    /**
     *  @Route("/admin/collectors/sendingeventsschedules/{collector}/{page}", name="load_sendingevents_schedule", defaults={"page" = 1}, options={"expose"=true})
     */
    public function loadSendingEventsScheduleAction(Request $request, $collector, $page){

        //Getting logger
        $logger = $this->get('logger');

        //Getting service
        $collectorService = $this->get('collector_service');
        $scheduleService = $this->get('schedule_service');

        //Getting registered collector
        $coll = $collectorService->findByCode($collector);

        if($coll!=null) {
            //Load schedules
            $sendingEventsSchedule = $scheduleService->findSendingEventsScheduleByCollector($coll, ($page - 1) * 5, 5);
            $countCollection = $scheduleService->countAllSendingEventsScheduleByCollector($coll);
            if ($countCollection <= 5) {
                $maxCollection = 1;
            } else {
                if (fmod(($countCollection / 2), 5) == 0) {
                    $maxCollection = floor($countCollection / 5);
                } else {
                    $maxCollection = floor($countCollection / 5) + 1;
                }
            }

        }

        return $this->render('admin/collector/form_send_events.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'records' => $sendingEventsSchedule,
            'max'=>$maxCollection,
            'current_page'=>$page,
            'collector_code'=>$collector,
        ));

    }

    /**
     *  @Route("/admin/collectors/collectiondataschedule/add/{collector}", name="add_collectiondata_schedule", options={"expose"=true})
     */
    public function addCollectionFixedSchedule(Request $request, $collector){

        $defaultData = array();
        $form = $this->createFormBuilder($defaultData)
            ->add('collectionTime', 'time', array(
                'input'  => 'datetime',
                'widget' => 'choice',))
            ->add('save', 'submit')
            ->getForm();

        $form->handleRequest($request);


        return $this->render('admin/collector/add_collect_data.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'form'=>$form->createView(),
        ));
    }


}