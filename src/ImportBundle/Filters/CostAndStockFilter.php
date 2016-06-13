<?php

namespace ImportBundle\Filters;

use Ddeboer\DataImport\Filter\FilterInterface;
use ImportBundle\Exception\FilterException;

class CostAndStockFilter extends BaseFilter implements FilterInterface
{
    protected $costField;

    protected $stockField;

    protected $minCost;

    protected $maxCost;

    protected $minStock;

    public function __construct($costField, $stockField, $minCost = 5, $maxCost = 1000, $minStock = 10)
    {
        $this->costField = $costField;
        $this->stockField = $stockField;

        $this->minCost = $minCost;
        $this->maxCost = $maxCost;
        $this->minStock = $minStock;
    }

    public function filter(array $item)
    {
        if (!array_key_exists($this->costField, $item) || !array_key_exists($this->stockField, $item)) {
            throw new FilterException("Cost or stock fields not found in current reader row");
        }

        $cost = $item[ $this->costField ];
        $stock = $item[ $this->stockField ];

        if (!is_numeric($cost) || !is_numeric($stock)) {
            throw new FilterException("Cost or stock values should be numeric");
        }

        if ($cost > $this->minCost && $cost < $this->maxCost && $stock > $this->minStock) {
            return true;
        }

        return false;
    }

    public function getPriority()
    {
        return 0;
    }
}