<?php
/**
 * PHP version: 5.6+
 */
namespace ImportBundle\Helper;

/**
 * Interface IImport
 *
 * With implements this interface you can create your logic for data import
 * See details in interface method
 *
 * @package ImportBundle\Helper
 * @codeCoverageIgnore
 */
interface IImport
{
    /**
     * Return from this method int value related to header position
     * in your source files.
     *
     * @return int
     */
    public function getHeadersPosition();

    /**
     * Return array with mapping from this method.
     * In mappings you can specify "from" and "to" column names
     *
     * @return mixed
     */
    public function getMapping();

    /**
     * Add few values converters here.
     * Value converter will convert value before import.
     * More details available on https://github.com/ddeboer/DdeboerDataImportBundle
     *
     * @return mixed
     */
    public function getValueConverters();

    /**
     * Add default of implement your own filers. Return all filters as array
     * More details about filter, please see https://github.com/ddeboer/DdeboerDataImportBundle
     *
     * @return mixed
     */
    public function getFilters();

    /**
     * Specify here doctrine destination entity name
     *
     * @return mixed
     */
    public function getDestinationEntity();
}
