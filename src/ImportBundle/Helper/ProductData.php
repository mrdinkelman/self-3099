<?php
/**
 * PHP version: 5.6+
 */
namespace ImportBundle\Helper;

use ImportBundle\Filters\CostAndStockFilter;
use ImportBundle\ItemConverter\DiscontinuedConverter;

/**
 * Class ProductData
 * Helper for organizing import from customer CSV file
 * related to product.
 *
 * @package ImportBundle\Helper
 */
class ProductData implements IImport
{
    /**
     * Name of destination doctrine entity
     *
     * @return string
     */
    public function getDestinationEntity()
    {
        return "ImportBundle:ProductData";
    }

    /**
     * Headers position row number in source
     *
     * @return int
     */
    public function getHeadersPosition()
    {
        return 0;
    }

    /**
     * Columns mapping
     *
     * @return array
     */
    public function getMapping()
    {
        return [
            'Product Code' => 'productCode',
            'Product Name' => 'productName',
            'Product Description' => 'productDesc',
            'Stock' => 'stock',
            'Cost in GBP' => 'costInGBP',
            'Discontinued' => 'discontinued'
        ];
    }

    /**
     * Value converters
     *
     * @return array
     */
    public function getValueConverters()
    {
        return [
            "discontinued" => new DiscontinuedConverter()
        ];
    }

    /**
     * Filters related to import process. Each filter will be called
     * before row will be inserted in db
     *
     * @return array
     */
    public function getFilters()
    {
        return [
            new CostAndStockFilter('Cost in GBP', 'Stock')
        ];
    }
}
