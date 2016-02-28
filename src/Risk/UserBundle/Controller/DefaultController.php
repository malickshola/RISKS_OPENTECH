<?php

namespace Risk\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('RiskUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
