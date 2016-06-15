<?php

class DiscontinuedConverterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \ImportBundle\ItemConverter\DiscontinuedConverter()
     */
    protected $tester;

    public function setUp()
    {
        $this->tester = new \ImportBundle\ItemConverter\DiscontinuedConverter();
    }

    public function testConvert()
    {
        $this->assertNull($this->tester->convert(""));
        $this->assertNotNull($this->tester->convert("yes"));
    }

}
