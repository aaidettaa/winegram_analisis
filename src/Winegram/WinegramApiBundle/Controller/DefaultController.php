<?php

namespace Winegram\WinegramApiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Winegram\WinegramAnalisisBundle\Domain\Service\LoadData\LoadData;
use Winegram\WinegramApiBundle\Services\Redis\RedisClient;

class DefaultController extends Controller
{
    const SOCIAL_POOL = 'social-list';

    /**
     * @var RedisClient
     */
    private $redis;

    /**
     * @Route("/")
     */
    public function indexAction()
    {

        /** @var LoadData $loadData */
        $loadData = $this->get('winegram_load_data');
//        $this->redis = $this->get('redis_client');
//
//        $data = $this->redis->lpop(self::SOCIAL_POOL);
//        $arr_redis = json_decode($data, true);



        $arr_redis = Array(
            'id' => '1282734191380998787_217731905',
            'type' => 'instagram_post',
            'text' => 'Perelada 5 Finques Reserva 2012 (Empord\u00e0) #vino #tinto #videocata #uvinum @c_perelada @do_emporda',
            'username' => 'Uvinum',
            'media' => 'https:\/\/scontent.cdninstagram.com\/t51.2885-15\/s640x640\/e15\/13534352_1646270189032613_1704621561_n.jpg?ig_cache_key=MTI4MjczNDE5MTM4MDk5ODc4Nw%3D%3D.2',
            'likes_count' => 23,
            'tags' => array (
                0 => 'uvinum',
                1 => 'videocata',
                2 => 'vino',
                3 => 'tinto'
            ),
            'search_id' => 1,
            'search_content' => '',
            'query' => 'uvinum' );
//        $arr_redis = json_decode($redis, true);

        print_r($arr_redis);
//        exit();

//        $loadData->load($arr_redis);
        print_r('final');
        exit();
        return $this->render('WinegramApiBundle:Default:index.html.twig');
    }
}
