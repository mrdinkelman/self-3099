<?php
/**
 * PHP version: 5.6+
 */
namespace ImportBundle\Exception;

use Ddeboer\DataImport\Exception\ExceptionInterface;

/**
 * Class RuntimeException
 * Added for run-time or general exceptions in import process
 *
 * @package ImportBundle\Exception
 */
class RuntimeException extends \RuntimeException implements ExceptionInterface
{

}