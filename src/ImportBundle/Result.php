<?php

namespace ImportBundle;

class Result extends \Ddeboer\DataImport\Result
{
    protected $filtered = array();

    public function __construct($name, \DateTime $startTime, \DateTime $endTime, $totalCount, $exceptions, $filtered)
    {
        parent::__construct($name, $startTime, $endTime, $totalCount, $exceptions);

        $this->filtered = $filtered;
    }

    public function getFiltered()
    {
        return $this->filtered;
    }
}