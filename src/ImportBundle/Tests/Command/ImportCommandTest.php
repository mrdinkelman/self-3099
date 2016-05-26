<?php

namespace ImportBundle\Tests\Command;

use ImportBundle\Command\ImportCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class ImportCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $kernel = $this->createKernel();
        $kernel->boot();

        $application = new Application($kernel);
        $application->add(new ImportCommand());

        $command = $application->find('import:import');

        $commandTest = new CommandTester($command);
        $commandTest->execute(array());

        $this->assertContains("Hello, I'm a first console application", $commandTest->getDisplay());

    }
}