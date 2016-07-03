<?php

namespace Winegram\WinegramApiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WinegramAnalisisBundle\Domain\Service\LoadData\LoadData;
use Winegram\WinegramApiBundle\Services\Redis\RedisClient;
use SqsPhpBundle\Client\Client;

class DefaultController extends Controller
{
    const SOCIAL_POOL = 'social-list';

    /**
     * @Route("/")
     */
    public function indexAction()
    {

        /** @var LoadData $loadData */
        $loadData = $this->get('winegram_load_data');
        /** @var RedisClient $redis */
        $redis = $this->get('redis_client');
        /** @var Client $sqs */
        $sqs = $this->get('sqs_php.client');

        $data = $redis->lpop(self::SOCIAL_POOL);
        $arr_redis = json_decode($data, true);
        $id_comment = $loadData->load($arr_redis);
        $sqs->send('indexing_queue', array("type" => "comment", "id" => $id_comment));

        print_r('final');
        exit();
        return $this->render('WinegramApiBundle:Default:index.html.twig');
    }
}
