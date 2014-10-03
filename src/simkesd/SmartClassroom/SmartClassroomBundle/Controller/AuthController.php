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
     * @Method({"GET"})
     * @Template("SmartClassroomBundle:Auth:login.html.twig")
     */
    public function loginAction()
    {
        return array();
    }


    /**
     * @Route("/login", name="login_post")
     * @Method({"POST"})
     * @Template("SmartClassroomBundle:Default:index.html.twig")
     */
    public function postLoginAction()
    {
        $request = $this->get('request')->request;
        $user = $this->container->get('fos_user.user_manager')->findUserByUsernameOrEmail($request->get('username_email'));

        // Email passed. Let's encode the password sent to us using the user's salt.
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
        $encoded_pass = $encoder->encodePassword($request->get('password'), $user->getSalt());
        // Check if the password sent to us matches encoded_pass we just created.
        if ($encoded_pass === $user->getPassword()) {
            $session = $this->get('session');
            $session->set('user', $user);
            return array();
        }

        var_dump('fail');die;
        return $this->redirect($this->generateUrl('register_post'), 301);
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

    /**
     * @Route("/logout", name="logout_get")
     */
    public function logoutAction()
    {
        return $this->redirect($this->generateUrl('login_get'), 301);
    }

}
