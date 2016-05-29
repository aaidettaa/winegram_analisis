<?php

namespace TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Winegram\WinegramAnalisisBundle\LoadData\LoadData;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $test = new LoadData();
        $test->load();
        exit();
        return $this->render('TestBundle:Default:index.html.twig');
    }
}
