<?php

namespace simkesd\SmartClassroom\SmartClassroomBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
     * @Route("/admin/dashboard")
     * @Template("SmartClassroomBundle:Default:index.html.twig")
     */
    public function dashboardAction()
    {
        return array();
    }

    /**
     * @return array
     *
     * @Route("/admin/profile")
     * @Template("SmartClassroomBundle:Default:index.html.twig")
     */
    public function profileAction()
    {
        return array();
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
     * @Route("/admin/profile/edit")
     * @Method({"POST"})
     */
    public function postEditProfileAction()
    {

    }


}
