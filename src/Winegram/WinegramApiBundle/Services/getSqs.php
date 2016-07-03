<?php

namespace Winegram\WinegramApiBundle\Services;

use Psr\Log\LoggerInterface;
use SqsPhpBundle\Client\Client;
use Winegram\WinegramAnalisisBundle\Domain\Service\LoadData\LoadData;
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

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(RedisClient $redis, LoadData $loadData, Client $sqs, LoggerInterface $logger)
    {
        $this->redis = $redis;
        $this->loadData = $loadData;
        $this->sqs = $sqs;
        $this->logger = $logger;
    }

    public function getSqsMessage($message){
        var_dump('msg');
//        var_dump($message);
//        echo $message;
        //bin/console sqs:worker:start social_queue
        $this->logger->info('New message');
        $data = $this->redis->lpop(self::SOCIAL_POOL);
        $arr_redis = json_decode($data, true);
        $id_comment = $this->loadData->load($arr_redis);
        $this->logger->info('Final proces message');
//        var_dump($id_comment);
        $this->sqs->send('indexing_queue', array( "type" => "comment", "id" => $id_comment ));
    }
}
