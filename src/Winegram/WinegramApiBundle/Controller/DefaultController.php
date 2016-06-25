<?php

namespace Winegram\WinegramApiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Winegram\WinegramAnalisisBundle\Application\Service\LoadData\LoadData;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {

        /** @var LoadData $loadData */
        $loadData = $this->get('winegram_load_data');

        $redis = '{
"id":"744197182912266243",
"type":"tweet",
"text":"Pruno, el Mejor Vino del Mundo",
"media": "",
"username":"test",
"likes_count":6,
"search_id": "3",
"query": "pruno",
"search_content": "",
"tags": ""
}';
        $arr_redis = json_decode($redis, true);

        $loadData->load($arr_redis);
        print_r('final');
        exit();
        return $this->render('WinegramApiBundle:Default:index.html.twig');
    }
}
