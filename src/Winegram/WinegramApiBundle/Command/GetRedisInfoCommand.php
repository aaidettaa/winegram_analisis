<?php

namespace Winegram\WinegramApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Winegram\WinegramApiBundle\Services\Redis\RedisClient;
use WinegramAnalisisBundle\Domain\Service\LoadData\LoadData;

class GetRedisInfoCommand extends ContainerAwareCommand
{
    const SOCIAL_POOL = 'social-list';

    /**
     * @var RedisClient
     */
    private $redis;

    protected function configure()
    {
        $this
            ->setName('winegram:getRedis')
            ->setDescription('Get Redis Twitt')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Inicio');

        /** @var LoadData $loadData */
        $loadData = $this->getContainer()->get('winegram_load_data');
        $this->redis = $this->getContainer()->get('redis_client');

        $data = $this->redis->lpop(self::SOCIAL_POOL);

        $output->writeln('Empieza proceso de: '.$data);

        $arr_redis = json_decode($data, true);

        $id_comment = $loadData->load($arr_redis);

//        $id_comment = 0;
        $output->writeln('Commentario creado: '.$id_comment);

        $output->writeln('Fin');
    }

}