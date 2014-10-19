<?php

namespace simkesd\SmartClassroom\SmartClassroomBundle\Controller;

use simkesd\SmartClassroom\SmartClassroomBundle\Entity\Actuator;
use simkesd\SmartClassroom\SmartClassroomBundle\Entity\Collection;
use simkesd\SmartClassroom\SmartClassroomBundle\Entity\Sensor;
use simkesd\SmartClassroom\SmartClassroomBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use simkesd\SmartClassroom\SmartClassroomBundle\Form\EditProfileType;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


class DefaultController extends Controller
{
    /**
     * @Route("/index/{name}")
     * @Template()
     */
    public function indexAction($name)
    {
        return array('name' => $name);
    }

    /**
     * @Route("/admin/dashboard", name="admin_dashboard")
     * @Template("SmartClassroomBundle:Default:dashboard.html.twig")
     */
    public function dashboardAction()
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $this->get('security.context')->getToken()->getUser();

        return array('user'=>$user);
    }

    /**
     * @return array
     *
     * @Route("/admin/profile", name="profile")
     * @Template("SmartClassroomBundle:Default:profile.html.twig")
     */
    public function profileAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();

        $form = $this->createFormBuilder($user)
            ->add('email', 'text', array('data'=>$user->getEmail()))
            ->add('username', 'text', array('data'=>$user->getUsername()))
            ->add('save', 'submit', array('label' => 'Create Post'))
            ->getForm();

        return array('user'=>$user, 'form' => $form->createView());

        $user = new User();

        $form = $this->createForm(new EditProfileType(), $user);
        exit;
    }

    /**
     * @return array
     *
     * @Route("/admin/profile/edit")
     * @Method({"GET"})
     * @Template("SmartClassroomBundle:Auth:register.html.twig")
     */
    public function editProfileAction()
    {
        return array();
    }

    /**
     *
     * @Route("/admin/profile/edit", name="edit_profile")
     * @Method({"POST"})
     * @Template("SmartClassroomBundle:Default:profile.html.twig")
     */
    public function postEditProfileAction()
    {
        $request = $this->get('request')->request;

        $userManager = $this->get('fos_user.user_manager');
        $user = $this->get('security.context')->getToken()->getUser();
        $user->setUsername($request->get('username'));
        $user->setEmail($request->get('email'));

        $form = $this->createFormBuilder($user)
            ->add('email', 'text')
            ->add('username', 'text')
            ->add('save', 'submit', array('label' => 'Create Post'))
            ->getForm();

        $form->handleRequest($this->get('request'));
//        if($request->get('password') != $request->get('confirm_password')) {
//            return $this->redirect($this->generateUrl('register_post'), 301);
//        }

//        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
//        $password = $encoder->encodePassword($request->get('password'), $user->getSalt());
//        $user->setPassword($password);

        $validator = $this->get('validator');
        $errors = $validator->validate($user);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            die('error');
            return array('errors'=>$errors, 'user'=>$user);
        }

        $userManager->updateUser($user);
//        var_dump($request);die;
        return $this->redirect($this->generateUrl('profile'), 301);
    }

    /**
     * @return array
     *
     * @Route("/admin/list-collections", name="list_collections")
     * @Template("SmartClassroomBundle:Default:listCollections.html.twig")
     */
    public function listCollectionsAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository('SmartClassroomBundle:Collection');

        $query = $repository->createQueryBuilder('c')->getQuery();;

        $collections = $query->getResult();
        $userManager = $this->get('fos_user.user_manager');
        $user = $this->get('security.context')->getToken()->getUser();
        return array('collections'=>$collections, 'user'=>$user);
    }

    /**
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/admin/create-collection", name="create_collection")
     * @Template("SmartClassroomBundle:Default:createCollection.html.twig")
     */
    public function createCollectionAction()
    {
        $request = $this->get('request');

        $collection = new Collection();
        $form = $this->createFormBuilder($collection)
            ->add('name')
            ->add('file')
            ->add('description')
            ->add('location_description')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($collection);
            $em->flush();

            return $this->redirect($this->generateUrl('list_collections'), 301);
        }

        $userManager = $this->get('fos_user.user_manager');
        $user = $this->get('security.context')->getToken()->getUser();

        return array('form' => $form->createView(), 'user' => $user);
    }

    /**
     * @param $id
     * @return array
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @Route("/admin/collection/{id}", name="single_collection", requirements={"id" = "\d+"}, defaults={"id" = 1})
     * @Template("SmartClassroomBundle:Default:singleCollection.html.twig")
     */
    public function singleCollectionAction($id)
    {
        $collection = $this->getDoctrine()
            ->getRepository('SmartClassroomBundle:Collection')
            ->find($id);

        $sensor = $this->getDoctrine()
            ->getRepository('SmartClassroomBundle:Sensor')
            ->find(1);

        if (!$collection) {
            throw $this->createNotFoundException(
                'No collection found for id '.$id
            );
        }

        $actuators = $collection->getActuators();

        $userManager = $this->get('fos_user.user_manager');
        $user = $this->get('security.context')->getToken()->getUser();

        return array('collection'=>$collection, 'user'=>$user, 'actuators'=>$actuators);
    }

    /**
     * @return array
     *
     * @Route("/admin/create-sensor", name="create_sensor_post")
     * @Method({"POST"})
     */
    public function postCreateSensorAction()
    {
        $request = $this->get('request')->request;

        $collection = $this->getDoctrine()
            ->getRepository('SmartClassroomBundle:Collection')
            ->find($request->get('collection_id'));

        $sensor = new Sensor();
        $sensor->setName($request->get('name'));
        $sensor->setDescription($request->get('description'));
//        $sensor->setLocationDescription($request->get('locationDescription'));
        $sensor->setCollection($collection);
        $em = $this->getDoctrine()->getManager();
        $em->persist($sensor);
        $em->flush();

        return $this->redirect($this->generateUrl('list_collections'), 301);
    }

    /**
     * @param $collection_id
     * @return array
     *
     * @Route("/admin/create-sensor/{collection_id}", name="create_sensor", requirements={"collection_id" = "\d+"})
     * @Method({"GET"})
     * @Template("SmartClassroomBundle:Default:createSensor.html.twig")
     */
    public function createSensorAction($collection_id)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $this->get('security.context')->getToken()->getUser();
        return array('user'=>$user, 'collection_id'=>$collection_id);
    }

    /**
     * @param $collection_id
     * @return array
     *
     * @Route("/admin/create-actuator/{collection_id}", name="create_actuator", requirements={"collection_id" = "\d+"})
     * @Method({"GET"})
     * @Template("SmartClassroomBundle:Default:createActuator.html.twig")
     */
    public function createActuatorAction($collection_id)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $this->get('security.context')->getToken()->getUser();
        return array('user'=>$user, 'collection_id'=>$collection_id);
    }

    /**
     * @return array
     *
     * @Route("/admin/create-actuator", name="create_actuator_post")
     * @Method({"POST"})
     */
    public function postCreateActuatorAction()
    {
        $request = $this->get('request')->request;

        $collection = $this->getDoctrine()
            ->getRepository('SmartClassroomBundle:Collection')
            ->find($request->get('collection_id'));

        $actuator = new Actuator();
        $actuator->setName($request->get('name'));
        $actuator->setDescription($request->get('description'));
//        $actuator->setLocationDescription($request->get('locationDescription'));
        $actuator->setCollection($collection);
        $em = $this->getDoctrine()->getManager();
        $em->persist($actuator);
        $em->flush();

        return $this->redirect($this->generateUrl('list_collections'), 301);
    }

    /**
     * @param $id
     * @return array
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @Route("/admin/sensor/{id}", name="single_sensor", requirements={"id" = "\d+"}, defaults={"id" = 1})
     * @Template("SmartClassroomBundle:Default:singleSensor.html.twig")
     */
    public function singleSensorAction($id)
    {
        $sensor = $this->getDoctrine()
            ->getRepository('SmartClassroomBundle:Collection')
            ->find($id);

        if (!$sensor) {
            throw $this->createNotFoundException(
                'No sensor found for id '.$id
            );
        }

        $userManager = $this->get('fos_user.user_manager');
        $user = $this->get('security.context')->getToken()->getUser();

        return array('sensor'=>$sensor, 'user'=>$user);
    }

    /**
     * @param $id
     * @return array
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @Route("/admin/sensor-values/{id}", name="single_sensor_values", requirements={"id" = "\d+"}, defaults={"id" = 1})
     */
    public function sensorValues($id)
    {
        $sensor = $this->getDoctrine()
            ->getRepository('SmartClassroomBundle:Sensor')
            ->find($id);
        $sensorValues = $sensor->getSensorValues()->getValues();

        $values = array();
        foreach($sensorValues as $s) {
            $values[] = array('id' => $s->getId(), 'value' => $s->getValue());
        }

        $response = new Response(json_encode($values));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
//        return new JsonResponse(array('s'=>$sensor->getSensorValues()->getValues()));
        exit;

        $sensorValues = $sensor->getCollection()->getName();

        if (!$sensorValues) {
            throw $this->createNotFoundException(
                'No sensor found for id '.$id
            );
        }

        $userManager = $this->get('fos_user.user_manager');
        $user = $this->get('security.context')->getToken()->getUser();

        var_dump($sensorValues);
    }

}