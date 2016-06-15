<?php
/**
 * PHP version: 5.6+
 */
namespace ImportBundle\ItemConverter;

use Ddeboer\DataImport\ValueConverter\ValueConverterInterface;
use ImportBundle\Helper\DateTime;

/**
 * Class DiscontinuedConverter
 *
 * Value converter for 'discontinued' field. Main idea is: if value
 * exists in this field, just set current date time
 *
 * For more information, see customer requirements
 *
 * @package ImportBundle\ItemConverter
 */
class DiscontinuedConverter implements ValueConverterInterface
{
    /**
     * Conversion
     *
     * @param mixed $input
     *
     * @return DateTime|null
     */
    public function convert($input)
    {
        if (empty($input)) {
            return null;
        }

        return new DateTime();
    }
}