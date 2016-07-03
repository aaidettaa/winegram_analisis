<?php

namespace Winegram\WinegramApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use WinegramAnalisisBundle\Application\Service\GenderDetection\DatumboxGenderDetection;
use WinegramAnalisisBundle\Domain\Entity\Comment;
use WinegramAnalisisBundle\Domain\Repository\CommentRepository;

class ProcesGenderCommand extends ContainerAwareCommand
{


    protected function configure()
    {
        $this
            ->setName('winegram:procesGender')
            ->setDescription('proces Gender ');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Inicio');

        /** @var DatumboxGenderDetection $service */
        $service = $this->getContainer()->get('winegram_datumbox_gender_detection');
        $doctrine = $this->getContainer()->get('doctrine.orm.entity_manager');

        /** @var CommentRepository $commentR */
        $commentR = $doctrine->getRepository('WinegramAnalisisBundle:Comment');

        $comments = $commentR->findBy(array('textSentiment' => null));

        /** @var Comment $the_comment */
        foreach ($comments as $the_comment) {
            $gender = $service->detect($the_comment->getEnglishText());
            if ($gender != false) {
                $the_comment->setGender($gender);
            }else{
                $output->writeln('ERROR: '.$the_comment->getEnglishText().' ('.$the_comment->getId().')');
            }
            $doctrine->persist($the_comment);
        }

        $doctrine->flush();
        $output->writeln('Fin');
    }

}