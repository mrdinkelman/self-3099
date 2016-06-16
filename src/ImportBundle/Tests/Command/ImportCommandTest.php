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
        $command = new ImportCommand();
        $application->add($command);

        $command = $application->find('import:products');

        // success
        $commandTest = new CommandTester($command);
        $this->assertEquals(ImportCommand::CODE_SUCCESS, $commandTest->execute(['--test-mode' => 1]));

        $this->assertEquals(ImportCommand::CODE_GENERAL_EXC, $commandTest->execute(['--file' => 'foo']));
    }
}