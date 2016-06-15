<?php
/**
 * Created by PhpStorm.
 * User: a2.ilin
 * Date: 15/06/16
 * Time: 20:12
 */

namespace Entity;


use ForceUTF8\Encoding;
use ImportBundle\Entity\ProductData;

class ProductDataTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ProductData
     */
    protected $tester;

    public function setUp()
    {
        $this->tester = new ProductData();
    }

    public function testGetAdded()
    {
        $this->assertNotNull($this->tester->getAdded());
        $this->assertNotEmpty($this->tester->getAdded());
    }

    public function testProductName()
    {
        $encoded = Encoding::toLatin1('Â');

        $this->tester->setProductName("Â-foo-bar");
        $this->assertEquals("$encoded-foo-bar", $this->tester->getProductName());
    }

    public function testProductDesc()
    {
        $encoded = Encoding::toLatin1('Â');

        $this->tester->setProductDesc("Â-foo-bar");
        $this->assertEquals("$encoded-foo-bar", $this->tester->getProductDesc());
    }
}
