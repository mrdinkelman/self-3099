<?php
namespace ImportBundle\Tests;

use ImportBundle\Helper\ProductData;

class ProductDataTest extends \PHPUnit_Framework_TestCase
{
    public function testHelper()
    {
        $object = new ProductData();

        $this->assertInternalType('array', $object->getMapping());
        $this->assertNotEmpty($object->getMapping());

        $this->assertInternalType('string', $object->getDestinationEntity());
        $this->assertNotEmpty($object->getDestinationEntity());

        $this->assertInternalType('array', $object->getFilters());
        $this->assertNotEmpty($object->getFilters());

        $this->assertInternalType('array', $object->getValueConverters());
        $this->assertNotEmpty($object->getFilters());

        $this->assertInternalType('int', $object->getHeadersPosition());
        $this->assertGreaterThanOrEqual(0, $object->getHeadersPosition());
    }
}
