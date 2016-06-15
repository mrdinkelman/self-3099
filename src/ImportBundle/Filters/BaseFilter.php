<?php
/**
 * PHP version: 5.6+
 */
namespace ImportBundle\Filters;

/**
 * Class BaseFilter
 *
 * Improving filters functionality.
 * Adding BaseFilter for allow set reject reasons: Why filtered value
 * not accepted. This info may be useful for users because they want know
 * what's wrong with specified row or item
 *
 * @package ImportBundle\Filters
 */
class BaseFilter
{
    /**
     * Reject reason message
     * @var string
     */
    protected $rejectReason;

    /**
     * Set reject reason message
     *
     * @param $reason
     *
     * @return $this
     */
    public function setRejectReason($reason)
    {
        $this->rejectReason = $reason;

        return $this;
    }

    /**
     * Get reject reason message
     *
     * @return string
     */
    public function getRejectReason()
    {
        return $this->rejectReason;
    }
}