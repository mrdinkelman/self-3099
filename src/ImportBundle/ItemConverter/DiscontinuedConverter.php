<?php

namespace ImportBundle\ItemConverter;

use Ddeboer\DataImport\ValueConverter\ValueConverterInterface;
use ImportBundle\Helper\DateTime;

class DiscontinuedConverter implements ValueConverterInterface
{
    public function convert($input)
    {
        if (empty($input)) {
            return null;
        }

        return new DateTime();
    }
}