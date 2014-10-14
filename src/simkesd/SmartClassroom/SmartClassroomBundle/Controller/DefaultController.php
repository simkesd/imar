<?php

namespace simkesd\SmartClassroom\SmartClassroomBundle\Controller;

use simkesd\SmartClassroom\SmartClassroomBundle\Entity\Collection;
use simkesd\SmartClassroom\SmartClassroomBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use simkesd\SmartClassroom\SmartClassroomBundle\Form\EditProfileType;
use Symfony\Component\BrowserKit\Request;


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
        print_r($user);
        exit;
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
     * @return array
     *
     * @Route("/admin/create-collection", name="create_collection")
     * @Method({"GET"})
     * @Template("SmartClassroomBundle:Default:createCollection.html.twig")
     */
    public function createCollectionAction()
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $this->get('security.context')->getToken()->getUser();
        return array('user'=>$user);
    }

    /**
     * @return array
     *
     * @Route("/admin/create-collection", name="create_collection_post")
     * @Method({"POST"})
     */
    public function postCreateCollectionAction()
    {
        $request = $this->get('request')->request;

        $collection = new Collection();
        $collection->setName($request->get('name'));
        $collection->setDescription($request->get('description'));
        $collection->setLocationDescription($request->get('locationDescription'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($collection);
        $em->flush();

        return $this->redirect($this->generateUrl('list_collections'), 301);
    }


}
