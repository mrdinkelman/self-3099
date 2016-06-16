<?php
/**
 * PHP version: 5.6+
 */
namespace ImportBundle\Helper;

use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class ConsoleHelper
 * A little helper for console, prints information about errors, exceptions, filtered
 * rows
 *
 * @package ImportBundle\Helper
 */
class ConsoleHelper
{
    /**
     * Input/output SymfonyStyle
     * @var SymfonyStyle
     */
    protected $io;

    /**
     * Errors during import
     * @var array
     */
    protected $errors = array();

    /**
     * Rows, not accepted by filters during import
     * @var array
     */
    protected $filtered = array();

    /**
     * Exceptions in import process
     * @var array
     */
    protected $exceptions = array();

    /**
     * ConsoleHelper constructor.
     *
     * @param SymfonyStyle $io
     * @param array $errors
     * @param array $filtered
     * @param array $exceptions
     */
    public function __construct(SymfonyStyle $io, array $errors = array(),
        array $filtered = array(), array $exceptions = array()
    ) {
        $this->io = $io;

        $this->errors = $errors;
        $this->filtered = $filtered;
        $this->exceptions = $exceptions;
    }

    /**
     * Just prints everything
     * @codeCoverageIgnore
     */
    public function printInfo()
    {
        $this->printErrors();
        $this->printFiltered();
        $this->printExceptions();

    }

    /**
     * Print errors, return FALSE if errors doesn't exists
     *
     * @return bool
     */
    protected function printErrors()
    {
        if (empty($this->errors)) {
            return false;
        }

        $this->io->section("Reader errors:");

        foreach ($this->errors as $row => $error) {
            $this->io->text(
                sprintf(
                    "Row %3s: Error during reading, row data: %s",
                    $row,
                    json_encode($error))
            );
        }

        return true;
    }

    /**
     * Print unaccepted values by filters or returns FALSE if
     * all rows was accepted or no information about filtered rows given
     *
     * @return bool
     */
    protected function printFiltered()
    {
        if (empty($this->filtered)) {
            return false;
        }

        $this->io->section("Not accepted rows by filters:");

        foreach ($this->filtered as $row => $reason) {
            $this->io->text(sprintf("Row %3s: [Filtered] %s", $row, $reason));
        }

        return true;
    }

    /**
     * Print exceptions or return FALSE if no exceptions given
     *
     * @return bool
     */
    public function printExceptions()
    {
        if (empty($this->exceptions)) {
            return false;
        }

        $this->io->section("Filter's Exceptions:");

        /**
         * @var $exception \Exception
         */
        foreach ($this->exceptions as $row => $exception) {
            $this->io->text(sprintf("Row %3s: [Exception] %s", $row, $exception->getMessage()));
        }

        return true;
    }


}