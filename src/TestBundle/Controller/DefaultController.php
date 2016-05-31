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
        $em = $this->getDoctrine()->getManager();
        $all_twitts = [];
        $test->load($em, $all_twitts);
        exit();
        return $this->render('TestBundle:Default:index.html.twig');
    }
}
