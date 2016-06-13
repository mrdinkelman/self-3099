<?php

namespace ImportBundle;

use Ddeboer\DataImport\Reader\ReaderInterface;
use Symfony\Component\HttpKernel\Log\LoggerInterface;

class Workflow extends \Ddeboer\DataImport\Workflow
{
    public function __construct(ReaderInterface $reader, LoggerInterface $logger = null, $name = null)
    {
        parent::__construct($reader, $logger, $name);
    }

}