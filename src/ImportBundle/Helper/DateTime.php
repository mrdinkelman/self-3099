<?php
/**
 * PHP version: 5.6+
 */
namespace ImportBundle\Helper;

/**
 * Class DateTime
 *
 * Extend default datetime for using by external import library
 *
 * Reason: If with library we add ConsoleTableWriter for delivering
 * rows into console we always will get Exceptions that standard \DateTime
 * values can not be converted to string.
 *
 * Add small tweak for that, use standard format() method as __toString and
 * all will works fine :)
 *
 * @package ImportBundle\Helper
 */
class DateTime extends \DateTime implements \DateTimeInterface
{
    /**
     * String representation of current object
     *
     * @return string
     */
    public function __toString()
    {
        return $this->format("Y-m-d H:i:s");
    }
}