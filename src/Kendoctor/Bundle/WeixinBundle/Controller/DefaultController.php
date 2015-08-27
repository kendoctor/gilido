<?php

namespace Kendoctor\Bundle\WeixinBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function homeAction($account)
    {
        return $this->render('KendoctorWeixinBundle:Default:index.html.twig', array('name' => $account));
    }

    /**
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function briefOfPostAction($id)
    {
        return $this->render('KendoctorWeixinBundle:Default:briefOfPost.html.twig', array());
    }

    /**
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showOfPostAction($id)
    {
        return $this->render('KendoctorWeixinBundle:Default:showOfPost.html.twig', array());
    }

}
