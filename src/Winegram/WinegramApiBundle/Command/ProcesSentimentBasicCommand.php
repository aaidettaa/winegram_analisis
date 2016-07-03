<?php


namespace Winegram\WinegramApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Winegram\WinegramApiBundle\Services\Redis\RedisClient;
use WinegramAnalisisBundle\Application\Service\SentimentAnalysis\DatumboxSentimentAnalysis;
use WinegramAnalisisBundle\Application\Service\SentimentAnalysis\DatumboxTwitterSentimentAnalysis;
use WinegramAnalisisBundle\Application\Service\Translation\YandexTranslation;
use WinegramAnalisisBundle\Domain\Entity\Comment;
use WinegramAnalisisBundle\Domain\Repository\CommentRepository;

class ProcesSentimentBasicCommand extends ContainerAwareCommand
{


    protected function configure()
    {
        $this
            ->setName('winegram:procesSentimentBasic')
            ->setDescription('proces Sentiment Basic ');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Inicio');

        /** @var DatumboxSentimentAnalysis $service */
        $service = $this->getContainer()->get('winegram_datumbox_sentiment_analysis');
        /** @var DatumboxTwitterSentimentAnalysis $service2 */
        $service2 = $this->getContainer()->get('winegram_datumbox_twitter_sentiment_analysis');
        $doctrine = $this->getContainer()->get('doctrine.orm.entity_manager');

        /** @var CommentRepository $commentR */
        $commentR = $doctrine->getRepository('WinegramAnalisisBundle:Comment');

        $comments = $commentR->findBy(array('textSentiment' => null));

        /** @var Comment $the_comment */
        foreach ($comments as $the_comment) {
            $sentiment = $service->analize($the_comment->getEnglishText());
            if ($sentiment != false) {
                $the_comment->setTextSentiment($sentiment);
            }
            $twittSentiment = $service2->analize($the_comment->getEnglishText());
            if ($twittSentiment != false) {
                $the_comment->setTextTwittSentiment($twittSentiment);
            }
            $doctrine->persist($the_comment);
        }

        $doctrine->flush();
        $output->writeln('Fin');
    }

}