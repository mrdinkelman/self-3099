<?php

namespace ImportBundle\Services;

use Ddeboer\DataImport\Filter\FilterInterface;
use Ddeboer\DataImport\ItemConverter\ItemConverterInterface;
use Ddeboer\DataImport\Reader\CsvReader;
use Ddeboer\DataImport\Reader\ReaderInterface;
use Ddeboer\DataImport\Result;
use Ddeboer\DataImport\ValueConverter\ValueConverterInterface;
use Ddeboer\DataImport\Writer\WriterInterface;
use ImportBundle\Workflow;
use Symfony\Component\HttpKernel\Log\LoggerInterface;

class Import
{
    const EX_NO_READER = -1;
    const EX_NO_WRITER = -2;

    /**
     * @var CsvReader
     */
    protected $reader;

    protected $logger;

    protected $writers = array();

    protected $skipped = array();

    protected $filters = array();

    protected $itemConverters = array();
    protected $valueConverters = array();

    /**
     * @var Result
     */
    protected $result;

    /**
     * @var Workflow
     */
    protected $workflow;

    public function getReader() {
        return $this->reader;
    }

    public function getFile()
    {
        return $this->getFile();
    }

    public function getResult()
    {
        return $this->result;
    }

    public function addFilter(FilterInterface $filter)
    {
        array_push($this->filters, $filter);

        return $this;
    }

    public function setItemConverter(ItemConverterInterface $itemConverters)
    {
        array_push($this->itemConverters, $itemConverters);

        return $this;
    }

    public function addValueConverter($field, ValueConverterInterface $valueConverter)
    {
        array_push($this->valueConverters, array($field => $valueConverter));

        return $this;
    }

    public function setReader(ReaderInterface $reader, $headersRowNumber = 0)
    {
        $this->reader = $reader;
        $this->reader->setHeaderRowNumber($headersRowNumber);

        return $this;
    }

    public function addWriter(WriterInterface $writer)
    {
        array_push($this->writers, $writer);

        return $this;
    }

    public function setWorkFlow(Workflow $workflow)
    {
        $this->workflow = $workflow;

        return $this;
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;

        return $this;
    }

    public function process()
    {
        if (!$this->reader) {
            throw new \RuntimeException("Reader not initialized", self::EX_NO_READER);
        }

        if (empty($this->writers)) {
            throw new \RuntimeException("Writers not initialized", self::EX_NO_READER);
        }

        $workflow = new Workflow($this->reader, $this->logger);
        $workflow->setSkipItemOnFailure(true);

        foreach ($this->writers as $writer) {
            $workflow->addWriter($writer);
        }

        foreach ($this->filters as $filter) {
            $workflow->addFilter($filter);
        }

        foreach ($this->itemConverters as $converter) {
            $workflow->addItemConverter($converter);
        }

        foreach ($this->valueConverters as $converter) {
            $workflow->addValueConverter(key($converter), current($converter));
        }

        $this->result = $workflow->process();

        return true;
    }


}