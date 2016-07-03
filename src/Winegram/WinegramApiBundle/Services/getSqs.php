<?php

namespace Winegram\WinegramApiBundle\Services;


use SqsPhpBundle\Client\Client;
use WinegramAnalisisBundle\Application\Service\LoadData\LoadData;
use Winegram\WinegramApiBundle\Services\Redis\RedisClient;

class getSqs {

    const SOCIAL_POOL = 'social-list';

    /**
     * @var RedisClient
     */
    private $redis;

    /**
     * @var LoadData
     */
    private $loadData;

    /**
     * @var Client
     */
    private $sqs;

    public function __construct(RedisClient $redis, LoadData $loadData, Client $sqs)
    {
        $this->redis = $redis;
        $this->loadData = $loadData;
        $this->sqs = $sqs;
    }

    public function getSqsMessage($message){
        $data = $this->redis->lpop(self::SOCIAL_POOL);
        $arr_redis = json_decode($data, true);
        $id_comment = $this->loadData->load($arr_redis);
        $this->sqs->send('indexing_queue', array( "type" => "comment", "id" => $id_comment ));
    }
}
