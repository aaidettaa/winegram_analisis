<?php


namespace Winegram\WinegramApiBundle\Services\Analysis;


use SqsPhpBundle\Client\Client;
use Winegram\WinegramAnalisisBundle\Domain\Service\LoadData\LoadData;
use Winegram\WinegramApiBundle\Services\Redis\RedisClient;

class AnalysisClient {

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

    public function execute(){
//        var_dump($message);
//        echo $message;
        //bin/console sqs:worker:start social_queue
        $data = $this->redis->lpop(self::SOCIAL_POOL);
        $arr_redis = json_decode($data, true);
        $id_comment = $this->loadData->load($arr_redis);
        return $id_comment;
//        var_dump($id_comment);
//        $this->sqs->send('new-comment', array( "type" => "comment", "id" => $id_comment ));
    }
}