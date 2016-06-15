<?php

namespace ImportBundle\Helper;

use ImportBundle\Filters\CostAndStockFilter;
use ImportBundle\ItemConverter\DiscontinuedConverter;

class ProductData implements IImport {
    public function getDestinationEntity()
    {
        return "ImportBundle:ProductData";
    }

    public function getHeadersPosition()
    {
        return 0;
    }

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

    public function getValueConverters()
    {
        return [
            "discontinued" => new DiscontinuedConverter()
        ];
    }

    public function getFilters()
    {
        return [
            new CostAndStockFilter('Cost in GBP', 'Stock')
        ];
    }


}