<?php

namespace ImportBundle\Services;

use Ddeboer\DataImport\ItemConverter\MappingItemConverter;
use Ddeboer\DataImport\Reader\CsvReader;
use Ddeboer\DataImport\Reader\ReaderInterface;
use Ddeboer\DataImport\Writer\ArrayWriter;
use Ddeboer\DataImport\Writer\ConsoleProgressWriter;
use Ddeboer\DataImport\Writer\DoctrineWriter;
use Doctrine\ORM\EntityManager;
use ImportBundle\Exception\RuntimeException;
use ImportBundle\Helper\IImport;
use ImportBundle\Result;
use ImportBundle\Workflow;
use Symfony\Component\HttpKernel\Log\LoggerInterface;

class ImportCSVService
{
    protected $inputFile;

    protected $debug = false;

    protected $logger = null;

    protected $consoleOutput = true;

    protected $entityManager;

    protected $exceptions = array();

    protected $filtered = array();

    /**
     * @var ReaderInterface|CsvReader
     */
    protected $reader;

    /**
     * @var Result
     */
    protected $workflowResult;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     *
     * @var IImport
     */
    protected $helper;

    /**
     * @return mixed
     */
    public function getInputFile()
    {
        return $this->inputFile;
    }

    /**
     * @param \SplFileObject $inputFile
     *
     * @return $this
     */
    public function setInputFile(\SplFileObject $inputFile)
    {
        if (!$inputFile->isFile()) {
            throw new RuntimeException("Unable to add or read file $inputFile");
        }

        $this->inputFile = $inputFile;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDebug()
    {
        return $this->debug;
    }

    /**
     * @param bool $debug
     *
     * @return $this
     */
    public function setDebug($debug = false)
    {
        $this->debug = (bool) $debug;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHelper()
    {
        return $this->helper;
    }

    /**
     * @param IImport $helper
     *
     * @return $this
     */
    public function setHelper(IImport $helper)
    {
        $this->helper = $helper;

        return $this;
    }

    public function execute()
    {
        $this->reader = new CsvReader($this->inputFile);
        $this->reader->setHeaderRowNumber($this->helper->getHeadersPosition());

        $workflow = new Workflow($this->reader, $this->logger);

        if ($this->debug) {
            $testData = [];

            $workflow->addWriter(
                new ArrayWriter($testData)
            );
        } else {
            $workflow->addWriter(
                new DoctrineWriter(
                    $this->entityManager,
                    $this->helper->getDestinationEntity()
                )
            );
        }

        foreach ($this->helper->getFilters() as $filter) {
            $workflow->addFilter($filter);
        }

        foreach ($this->helper->getValueConverters() as $field => $valueConverter) {
            $workflow->addValueConverter($field, $valueConverter);
        }

        $workflow->addItemConverter(new MappingItemConverter($this->helper->getMapping()));
        $workflow->setSkipItemOnFailure(true);

        $this->workflowResult = $workflow->process();

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param LoggerInterface $logger
     *
     * @return $this
     */
    public function setLogger(LoggerInterface $logger = null)
    {
        $this->logger = $logger;

        return $this;
    }

    public function getWorkflowResult()
    {
        return $this->workflowResult;
    }

    public function getSuccessCount()
    {
        return $this->workflowResult->getSuccessCount();
    }

    public function getTotalProcessedCount()
    {
        return $this->workflowResult->getTotalProcessedCount();
    }

    public function getReader()
    {
        return $this->reader;
    }

    public function getReaderCount()
    {
        return $this->reader->count();
    }

    public function hasErrors()
    {
        return $this->workflowResult->hasErrors();
    }

    public function getWorkflowExceptions()
    {
        return $this->workflowResult->getExceptions();
    }

    public function getWorkflowExceptionsCount(){
        return count($this->getWorkflowExceptions());
    }









}