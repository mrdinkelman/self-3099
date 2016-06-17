<?php

namespace ImportBundle\Tests;

use ImportBundle\Exception\FilterException;
use ImportBundle\Filters\CostAndStockFilter;

class CostAndStockFilterTest extends \PHPUnit_Framework_TestCase
{
    public function testFilter()
    {
        // unable to detect input keys in item
        try {
            $tester = new CostAndStockFilter('cost', 'stock', 1, 2, 3);
            $tester->filter(['foo' => 'bar']);
        } catch (FilterException $ex) {
            $this->assertStringStartsWith('cost or stock fields', $ex->getMessage());
        }

        // values should be numeric
        try {
            $tester = new CostAndStockFilter('cost', 'stock', 1, 2, 3);
            $tester->filter(['cost' => 'bar', 'stock' => '']);
        } catch (FilterException $ex) {
            $this->assertStringStartsWith('cost or stock values should be numeric', $ex->getMessage());
        }

        // business rule: cost should be not greater then max accepted cost
        $tester = new CostAndStockFilter('cost', 'stock', 5, 100, 1000);
        $this->assertFalse($tester->filter(['cost' => 200, 'stock' => 300]));

        // business rule: don't accept less stock and cost values
        $this->assertFalse($tester->filter(['cost' => 4, 'stock' => 50]));

        $this->assertTrue($tester->filter(['cost' => 70, 'stock' => 500]));
    }

    public function testGetPriority()
    {
        $tester = new CostAndStockFilter('cost', 'stock', 1, 2, 3);
        $this->assertEquals(0, $tester->getPriority());
    }

}