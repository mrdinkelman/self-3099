<?php
/**
 * PHP version: 5.6+
 */
namespace ImportBundle\Filters;

use Ddeboer\DataImport\Filter\FilterInterface;
use ImportBundle\Exception\FilterException;

/**
 * Class CostAndStockFilter
 *
 * Custom filter for data-import library. This filter created by customer
 * business rules. See details for test task for more information
 *
 * @package ImportBundle\Filters
 */
class CostAndStockFilter extends BaseFilter implements FilterInterface
{
    /**
     * Name of cost field in source
     * @var string
     */
    protected $costField;

    /**
     * Name of stock field in source
     * @var string
     */
    protected $stockField;

    /**
     * Minimal cost value in pounds (GBP) defined in customer rules
     * @var int|float
     */
    protected $minCost;

    /**
     * Max cost value in pounds (GBP) defined in customer rules
     * @var int|float
     */
    protected $maxCost;

    /**
     * Min stock value defined in customer rules
     * @var int|float
     */
    protected $minStock;

    /**
     * CostAndStockFilter constructor.
     *
     * @param string $costField
     * @param string $stockField
     * @param int    $minCost
     * @param int    $maxCost
     * @param int    $minStock
     */
    public function __construct($costField, $stockField, $minCost = 5, $maxCost = 1000, $minStock = 10)
    {
        // column names
        $this->costField = $costField;
        $this->stockField = $stockField;

        // values for filter
        $this->minCost = $minCost;
        $this->maxCost = $maxCost;
        $this->minStock = $minStock;
    }

    /**
     * Filter method.
     * Return TRUE if value matches to filter rules, FALSE - if not matches or
     * throws filter exception if for example value type can't be processed by rules
     *
     * @param array $item
     *
     * @return bool
     * @throws FilterException
     */
    public function filter(array $item)
    {
        // first of all, keys in $item should exists
        if (!array_key_exists($this->costField, $item)
            || !array_key_exists($this->stockField, $item)
        ) {
            throw new FilterException(
                sprintf(
                    "%s or %s fields not found in current reader row",
                    $this->costField,
                    $this->stockField
                )
            );
        }

        // get values
        $cost = $item[ $this->costField ];
        $stock = $item[ $this->stockField ];

        // values should be numeric
        if (!is_numeric($cost) || !is_numeric($stock)) {
            throw new FilterException(
                sprintf(
                    "%s or %s values should be numeric, not empty. " .
                    "Given: cost <%s> = '%s', stock <%s> = '%s'",
                    $this->costField,
                    $this->stockField,
                    gettype($cost),
                    $cost,
                    gettype($stock),
                    $stock
                )
            );
        }

        // business rule: cost should be not greater then max accepted cost
        if ($cost > $this->maxCost) {
            $this->setRejectReason(
                sprintf(
                    "%s '%s' greater then '%s' defined in filter rules",
                    $this->costField,
                    $cost,
                    $this->maxCost
                )
            );

            return false;
        }

        // business rule: don't accept less stock and cost values
        if ($cost < $this->minCost && $stock < $this->minStock) {
            $this->setRejectReason(
                sprintf(
                    "Cost = '%s' and stock = '%s' don't match with filter rules: min cost = '%s', min stock = '%s'",
                    $cost,
                    $stock,
                    $this->minCost,
                    $this->minStock
                )
            );

            return false;
        }

        return true;
    }

    /**
     * Filter priority
     *
     * @return int
     */
    public function getPriority()
    {
        return 0;
    }
}