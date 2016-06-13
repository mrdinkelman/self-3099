<?php

namespace ImportBundle\Filters;

class BaseFilter
{
    protected $rejectReason;

    public function setRejectReason($reason)
    {
        $this->rejectReason = $reason;
    }

    public function getRejectReason()
    {
        return $this->rejectReason;
    }
}