<?php

namespace ImportBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName("import:import")
            ->setDescription('SELF-3099 simple console application')
            ->addOption(
                'test-mode',
                null,
                InputOption::VALUE_NONE,
                'If set, application will not make changes in db'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Hello, I'm a first console application");
    }
}