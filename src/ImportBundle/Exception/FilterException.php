<?php

namespace ImportBundle\Exception;

use Ddeboer\DataImport\Exception\ExceptionInterface;
use Ddeboer\DataImport\Exception\ReaderException;

class FilterException extends ReaderException implements ExceptionInterface
{
    public function __construct($message, $code = 0, \RuntimeException $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}