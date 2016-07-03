<?php


namespace Winegram\WinegramApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Winegram\WinegramApiBundle\Services\Redis\RedisClient;
use WinegramAnalisisBundle\Application\Service\Translation\YandexTranslation;
use WinegramAnalisisBundle\Domain\Entity\Comment;
use WinegramAnalisisBundle\Domain\Repository\CommentRepository;

class ProcesTranslationCommand extends ContainerAwareCommand
{


    protected function configure()
    {
        $this
            ->setName('winegram:procesTranslation')
            ->setDescription('proces Translation ');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Inicio');

        /** @var YandexTranslation $service */
        $service = $this->getContainer()->get('winegram_yandex_translation');
        $doctrine = $this->getContainer()->get('doctrine.orm.entity_manager');

        /** @var CommentRepository $commentR */
        $commentR = $doctrine->getRepository('WinegramAnalisisBundle:Comment');

        $comments = $commentR->findBy(array('lang' => null));

        /** @var Comment $the_comment */
        foreach ($comments as $the_comment) {
            $the_comment->setLang('es');
            $enText = $service->translate($the_comment->getOriginalText(), 'es' . "-en");
            if ($enText != false) {
                $the_comment->setEnglishText($enText);
            } else {
                $the_comment->setEnglishText($the_comment->getOriginalText());
            }
            $doctrine->persist($the_comment);
        }

        $doctrine->flush();
        $output->writeln('Fin');
    }

}