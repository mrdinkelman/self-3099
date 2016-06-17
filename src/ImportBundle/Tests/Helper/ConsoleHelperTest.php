<?php
/**
 * Created by PhpStorm.
 * User: a2.ilin
 * Date: 15/06/16
 * Time: 18:37
 */

namespace ImportBundle\Tests;

use ImportBundle\Exception\RuntimeImportException;
use ImportBundle\Helper\ConsoleHelper;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Tester\CommandTester;

class ConsoleHelperTest extends KernelTestCase
{
    /**
     * @var ConsoleHelper
     */
    protected $blankObject;
    protected $filledObject;

    public function setUp()
    {
        $command = new SimpleCommand('foo');
        $commandTest = new CommandTester($command);
        $commandTest->execute([]);

        $this->blankObject = new ConsoleHelper(
            new SymfonyStyle($commandTest->getInput(), $commandTest->getOutput()),
            [],
            [],
            []
        );

        $exception = new RuntimeImportException('exception');

        $this->filledObject = new ConsoleHelper(
            new SymfonyStyle($commandTest->getInput(), $commandTest->getOutput()),
            [0 => 'bar'],
            [0 => 'foo'],
            [0 => $exception]
        );
    }

    public function testPrintErrors()
    {
        $method = new \ReflectionMethod($this->blankObject, 'printErrors');
        $method->setAccessible(true);

        $this->assertEquals(false, $method->invoke($this->blankObject));

        $method = new \ReflectionMethod($this->filledObject, 'printErrors');
        $method->setAccessible(true);

        $this->assertEquals(true, $method->invoke($this->filledObject));
    }

    public function testPrintFiltered()
    {
        $method = new \ReflectionMethod($this->blankObject, 'printFiltered');
        $method->setAccessible(true);

        $this->assertEquals(false, $method->invoke($this->blankObject));

        $method = new \ReflectionMethod($this->filledObject, 'printFiltered');
        $method->setAccessible(true);

        $this->assertEquals(true, $method->invoke($this->filledObject));
    }

    public function testPrintExceptions()
    {
        $method = new \ReflectionMethod($this->blankObject, 'printExceptions');
        $method->setAccessible(true);

        $this->assertEquals(false, $method->invoke($this->blankObject));

        $method = new \ReflectionMethod($this->filledObject, 'printExceptions');
        $method->setAccessible(true);

        $this->assertEquals(true, $method->invoke($this->filledObject));
    }

    public function testPrintInfo()
    {
        $this->testPrintErrors();
        $this->testPrintFiltered();
        $this->testPrintExceptions();
    }
}

class SimpleCommand extends Command
{
    public function execute(InputInterface $input, OutputInterface $output){
        return true;
    }
}


