<?php

namespace simkesd\SmartClassroom\SmartClassroomBundle\Controller;

use simkesd\SmartClassroom\SmartClassroomBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

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
        return array();
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

        return array('user'=>$user);
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

        if($request->get('password') != $request->get('confirm_password')) {
            return $this->redirect($this->generateUrl('register_post'), 301);
        }

        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
        $password = $encoder->encodePassword($request->get('password'), $user->getSalt());
        $user->setPassword($password);

        $validator = $this->get('validator');
        $errors = $validator->validate($user);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            die('error');
            return array('errors'=>$errors);
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
        return array();
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
        return array();
    }

    /**
     * @return array
     *
     * @Route("/admin/create-collection", name="create_collection_post")
     * @Method({"POST"})
     */
    public function postCreateCollectionAction()
    {
        return array();
    }


}
