<?php
// src/TobookBundle/Command/MigrateCommand.php

namespace ClientBundle\Command;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use ClientBundle\Entity\Client;


class LoadCandidatsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('wild:load:candidats')
            ->setDescription('load candidats from a given file')
            ->addArgument(
                'file',
                InputArgument::REQUIRED,
                'file to read data from'
            )
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = $input->getArgument('file');
        $object = json_decode(file_get_contents($file), true);
        $candidats = $object['data'];
        $em = $this->getContainer()->get('doctrine')->getManager();

        foreach ($candidats as $candidat) {
            $entity = new Client();
            $entity->setNom($candidat['title']);
            $em->persist($entity);
        }
        $em->flush();

        $output->writeln(sprintf('<info>done</info>'));
    }
}