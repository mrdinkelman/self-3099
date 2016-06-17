<?php
/**
 * PHP version: 5.6+
 */
namespace ImportBundle\Writer;

use Ddeboer\DataImport\Writer\WriterInterface;

/**
 * Class NullWriter
 * Small helper for testing process. Base idea: saving memory
 *
 * Note: Do not use this writer in real processes, it's fake and
 * always return positive results.
 *
 * @package ImportBundle\Writer
 */
class NullWriter implements WriterInterface
{
    /**
     * Fake, do nothing
     * @return bool
     */
    public function prepare()
    {
        return true;
    }

    /**
     * Fake, do nothing
     *
     * @param array $item
     *
     * @return array
     */
    public function writeItem(array $item)
    {
        return $item;
    }

    /**
     * Fake, do nothing
     *
     * @return bool
     */
    public function finish()
    {
        return true;
    }
}
