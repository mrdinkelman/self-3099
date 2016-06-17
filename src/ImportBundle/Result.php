<?php
/**
 * PHP version: 5.6+
 */
namespace ImportBundle;

/**
 * Class Result
 * Sadly, but base result of data import not provide info about
 * not accepted rows by filters. Fix this and add this feature.
 *
 * @package ImportBundle
 */
class Result extends \Ddeboer\DataImport\Result
{
    /**
     * Filtered rows
     *
     * @var array
     */
    protected $filtered = [];

    /**
     * Result constructor.
     *
     * @param $name
     * @param \DateTime $startTime
     * @param \DateTime $endTime
     * @param $totalCount
     * @param array|\Ddeboer\DataImport\Exception\ExceptionInterface[] $exceptions
     * @param $filtered
     */
    public function __construct($name, \DateTime $startTime, \DateTime $endTime,
        $totalCount, $exceptions, $filtered
    ) {
        parent::__construct($name, $startTime, $endTime, $totalCount, $exceptions);

        $this->filtered = $filtered;
    }

    /**
     * Get filtered rows
     *
     * @return array
     */
    public function getFiltered()
    {
        return $this->filtered;
    }
}