<?php

namespace simkesd\SmartClassroom\SmartClassroomBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
class AuthController extends Controller
{
    /**
     * @Route("/login", name="login_get")
     * @Template("SmartClassroomBundle:Auth:login.html.twig")
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @return array
     *
     * @Route("/register", name="register_get")
     * @Method({"GET"})
     * @Template("SmartClassroomBundle:Auth:register.html.twig")
     */
    public function registerAction()
    {
//        $userManager = $this->get('fos_user.user_manager');
//        $user = $userManager->createUser();
//        $user->setUsername('John1');
//        $user->setEmail('john.doe1@example.com');
//
//        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
//        $password = $encoder->encodePassword('password', $user->getSalt());
//
//        $user->setPassword($password);
//        $userManager->updateUser($user);

        return array();
    }

    /**
     * @return array
     *
     * @Route("/register", name="register_post")
     * @Method({"POST"})
     * @Template("SmartClassroomBundle:Auth:register.html.twig")
     */
    public function postRegisterAction()
    {
        $request = $this->get('request')->request;

        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->createUser();
        $user->setUsername($request->get('username'));
        $user->setEmail($request->get('email'));

        if($request->get('password') != $request->get('confirm_password')) {
            return $this->redirect($this->generateUrl('register_post'), 301);
        }

        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
        $password = $encoder->encodePassword($request->get('password'), $user->getSalt());

        $user->setPassword($password);
        $userManager->updateUser($user);
        return $this->redirect($this->generateUrl('login_get'), 301);

    }

}
