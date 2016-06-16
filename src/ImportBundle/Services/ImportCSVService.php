<?php
/**
 * PHP version: 5.6+
 */
namespace ImportBundle\Services;

use Ddeboer\DataImport\ItemConverter\MappingItemConverter;
use Ddeboer\DataImport\Reader\CsvReader;
use Ddeboer\DataImport\Reader\ReaderInterface;
use Ddeboer\DataImport\Writer\ArrayWriter;
use Ddeboer\DataImport\Writer\DoctrineWriter;
use Doctrine\ORM\EntityManager;
use ImportBundle\Exception\RuntimeException;
use ImportBundle\Helper\IImport;
use ImportBundle\Result;
use ImportBundle\Workflow;
use Symfony\Component\HttpKernel\Log\LoggerInterface;

/**
 * Class ImportCSVService
 *
 * General service for import customer CSV file and insert records from it
 * in database.
 *
 * Debug mode means - no changes in real db, just emulate all process but
 * without writing
 *
 * Normal workflow:
 * - set file
 * - set helper
 * - [optional] set logger
 * - [optional] set debug mode
 * - execute
 *
 * and working with result in your class logic.
 *
 * @package ImportBundle\Services
 */
class ImportCSVService
{
    /**
     * Input file for import
     * @var \SplFileObject
     */
    protected $inputFile;

    /**
     * Debug mode, switched off by default
     * @var bool
     */
    protected $debug = false;

    /**
     * Logger, if needed
     * @var null
     */
    protected $logger = null;

    /**
     * Doctrine entity manager
     *
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * Helper with import rules, filters, mappings and etc
     *
     * @var IImport
     */
    protected $helper;

    /**
     * Reader, main ideas see https://github.com/ddeboer/DdeboerDataImportBundle
     *
     * @var ReaderInterface|CsvReader
     */
    protected $reader;

    /**
     * Workflow, main ideas see https://github.com/ddeboer/DdeboerDataImportBundle
     *
     * @var Result
     */
    protected $workflowResult;

    /**
     * ImportCSVService constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Set file for input and verify that file exists
     *
     * @param \SplFileObject $inputFile
     *
     * @return $this
     */
    public function setInputFile(\SplFileObject $inputFile)
    {
        // verification
        if (!$inputFile->isFile() || strtolower($inputFile->getExtension() != 'csv')) {
            throw new RuntimeException("Unable to add or read file $inputFile");
        }

        $this->inputFile = $inputFile;

        return $this;
    }

    /**
     * Return input file
     *
     * @return mixed
     * @codeCoverageIgnore
     */
    public function getInputFile()
    {
        return $this->inputFile;
    }

    /**
     * Set debug mode
     *
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
     * Get marker state for debug mode
     *
     * @return mixed
     * @codeCoverageIgnore
     */
    public function getDebug()
    {
        return $this->debug;
    }

    /**
     * Set helper for import process
     *
     * @param IImport $helper
     *
     * @return $this
     */
    public function setHelper(IImport $helper)
    {
        $this->helper = $helper;

        return $this;
    }

    /**
     * Get current helper
     *
     * @return mixed
     * @codeCoverageIgnore
     */
    public function getHelper()
    {
        return $this->helper;
    }

    /**
     * Set logger
     *
     * @param LoggerInterface $logger
     *
     * @return $this
     * @codeCoverageIgnore
     */
    public function setLogger(LoggerInterface $logger = null)
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * Get logger
     *
     * @return mixed
     * @codeCoverageIgnore
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * Execute import
     * Base ideas for workflow, just see https://github.com/ddeboer/DdeboerDataImportBundle
     *
     * @return $this
     *
     * @throws RuntimeException
     */
    public function execute()
    {
        // validate normal workflow, don't allow call execute
        // without setting file or helper
        if (!$this->inputFile || !$this->helper) {
            throw new RuntimeException("Wrong call. Please set-up input file and helper first.");
        }

        // set reader and init them
        $this->reader = new CsvReader($this->inputFile);
        $this->reader->setHeaderRowNumber($this->helper->getHeadersPosition());

        // init workflow
        $workflow = new Workflow($this->reader, $this->logger);

        $workflow->addWriter(
            new DoctrineWriter(
                $this->entityManager,
                $this->helper->getDestinationEntity()
            )
        );

        // emulate writing in debug mode
        if ($this->debug) {
            $workflow->clearWriters();
            $testData = [];

            $workflow->addWriter(
                new ArrayWriter($testData)
            );
        }

        // filter values
        foreach ($this->helper->getFilters() as $filter) {
            $workflow->addFilter($filter);
        }

        // convert values
        foreach ($this->helper->getValueConverters() as $field => $valueConverter) {
            $workflow->addValueConverter($field, $valueConverter);
        }

        // set mapping
        $workflow->addItemConverter(new MappingItemConverter($this->helper->getMapping()));
        $workflow->setSkipItemOnFailure(true);

        // process
        $this->workflowResult = $workflow->process();

        return $this;
    }

    /**
     * Get import result as workflow.
     *
     * @return Result
     */
    public function getWorkflowResult()
    {
        return $this->workflowResult;
    }

    /**
     * Get reader. Useful for getting info about wrong or
     * corrupted rows
     *
     * @return CsvReader|ReaderInterface
     */
    public function getReader()
    {
        return $this->reader;
    }
}
