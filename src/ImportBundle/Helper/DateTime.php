<?php

namespace ImportBundle\Helper;

class DateTime extends \DateTime
{
    public function __toString()
    {
        return $this->format("Y-m-d H:i:s");
    }
}