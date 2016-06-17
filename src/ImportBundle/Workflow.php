<?php
/**
 * PHP version: 5.6+
 */
namespace ImportBundle;

use ImportBundle\Filters\BaseFilter;
use Symfony\Component\HttpKernel\Log\LoggerInterface;

/**
 * Class Workflow
 * Extend exists workflow and improve filterItem method by
 * adding support to set explanation (reject) messages
 *
 * @package ImportBundle
 */
class Workflow extends \Ddeboer\DataImport\Workflow
{
    const MESS_UNKNOWN_REASON = "Unknown reason";

    /**
     * Collection of filtered rows
     * @var array
     */
    protected $filtered = [];

    /**
     * Filter item
     *
     * @param mixed $item
     * @param \SplPriorityQueue $filters
     * @return bool
     */
    public function filterItem($item, \SplPriorityQueue $filters)
    {
        // SplPriorityQueue must be cloned because it is a stack and thus drops
        // elements each time it is iterated over.
        foreach (clone $filters as $filter) {
            if (false === $filter->filter($item)) {
                // set reject reason possible only with BaseFilter
                // instances. Standard filters not support this feature
                if ($filter instanceof BaseFilter) {
                    $this->filtered[$this->reader->key()] = $filter->getRejectReason();

                    return false;
                }

                // another filer from the box. We don't know about reason
                // whey value was not pass filter validation
                $this->filtered[$this->reader->key()] = self::MESS_UNKNOWN_REASON;

                return false;
            }
        }

        // Return true if no filters failed
        return true;
    }

    /**
     * Handle parent process and return result as Result
     * instance from current realization.
     *
     * @return Result
     * @throws \Ddeboer\DataImport\Exception\ExceptionInterface
     */
    public function process()
    {
        // don't change logic in parent process
        $result = parent::process();

        // just set our filtered rows
        return new Result(
            $result->getName(),
            $result->getStartTime(),
            $result->getEndTime(),
            $result->getTotalProcessedCount(),
            $result->getExceptions(),
            $this->filtered
        );
    }

    /**
     * Small helper: Clear writers
     *
     * @return $this
     */
    public function clearWriters()
    {
        $this->writers = [];

        return $this;
    }
}
