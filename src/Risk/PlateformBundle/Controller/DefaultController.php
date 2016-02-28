<?php

namespace Risk\PlateformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('RiskPlateformBundle:Default:index.html.twig');
    }
    
    public function blacklistAction()
    {
        return $this->render('RiskPlateformBundle:Default:blacklistForm.html.twig');
    }
    
    public function mailAction()
    {
        return $this->render('RiskPlateformBundle:Default:emailForm.html.twig');
    }
}
