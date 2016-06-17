<?php
namespace Services;

use Doctrine\ORM\EntityManager;
use ImportBundle\Exception\RuntimeImportException;
use ImportBundle\Services\ImportCSVService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ImportCSVServiceTest extends KernelTestCase
{
    /**
     * @var ImportCSVService
     */
    protected $tester;

    /**
     * @var EntityManager
     */
    protected $em;


    public function setUp()
    {
        self::bootKernel();

        $this->em = static::$kernel->getContainer()->get('doctrine')->getManager();

        $this->tester = new ImportCSVService($this->em);
    }

    public function testSetInputFile()
    {
        try {
            $tester = clone $this->tester;

            $tester->setInputFile(new \SplFileObject(__FILE__));
        } catch (RuntimeImportException $ex) {
            $this->assertStringStartsWith("Unable to add or read file", $ex->getMessage());
        }
    }

    public function testExecute()
    {
        try {
            $tester = clone $this->tester;

            $tester->execute();
        } catch (RuntimeImportException $ex) {
            $this->assertStringStartsWith("Wrong call. Please set-up input file and helper first.", $ex->getMessage());
        }
    }
}
