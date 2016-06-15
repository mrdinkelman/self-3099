<?php

namespace ImportBundle;

use ImportBundle\Filters\BaseFilter;
use Symfony\Component\HttpKernel\Log\LoggerInterface;

class Workflow extends \Ddeboer\DataImport\Workflow
{
    protected $filtered = array();

    public function filterItem($item, \SplPriorityQueue $filters)
    {
        // SplPriorityQueue must be cloned because it is a stack and thus drops
        // elements each time it is iterated over.
        foreach (clone $filters as $filter) {
            if (false == $filter->filter($item)) {
                if ($filter instanceof BaseFilter) {
                    $this->filtered[$this->reader->key()] = $filter->getRejectReason();

                    return false;
                }

                $this->filtered[$this->reader->key()] = "Unknown reason";
                return false;
            }
        }

        // Return true if no filters failed
        return true;
    }

    public function process()
    {
        $result = parent::process();

        return new Result(
            $result->getName(),
            $result->getStartTime(),
            $result->getEndTime(),
            $result->getTotalProcessedCount(),
            $result->getExceptions(),
            $this->filtered
        );
    }
}