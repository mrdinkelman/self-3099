<?php
/**
 * PHP version: 5.6+
 */
namespace ImportBundle\Exception;

use Ddeboer\DataImport\Exception\ExceptionInterface;
use Ddeboer\DataImport\Exception\ReaderException;

/**
 * Class FilterException
 * Adding custom exception for filters.
 *
 * @package ImportBundle\Exception
 */
// @@codeCoverageIgnoreStart
class FilterException extends ReaderException implements ExceptionInterface
{

}
// @@codeCoverageIgnoreEnd