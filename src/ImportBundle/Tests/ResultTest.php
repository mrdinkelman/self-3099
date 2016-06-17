<?php

namespace ImportBundle;

use ImportBundle\Exception\RuntimeImportException;
use ImportBundle\Helper\DateTime;

class ResultTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Result
     */
    protected $tester;

    public function setUp()
    {
        $this->tester = new Result(
            'foo',
            new DateTime(),
            new DateTime(),
            10,
            [ new RuntimeImportException()],
            [ 1 => 'bar']
        );
    }

    public function testGetFiltered()
    {
        $property = new \ReflectionProperty($this->tester, 'filtered');
        $property->setAccessible(true);

        $this->assertNotEmpty($property->getValue($this->tester));
        $this->assertInternalType('array', $property->getValue($this->tester));
        $this->assertEquals(1, count($property->getValue($this->tester)));

        $filtered = $property->getValue($this->tester);
        $this->assertEquals('bar', array_shift($filtered));

        $this->assertSame($property->getValue($this->tester), $this->tester->getFiltered());
    }
}