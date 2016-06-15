<?php

namespace ImportBundle\Tests;

use ImportBundle\Helper\DateTime;

class DateTimeTest extends \PHPUnit_Framework_TestCase
{
    public function testToString()
    {
        $time = new \DateTime("now");

        $object = new DateTime($time->format("Y-m-d H:i:s"));

        $this->assertInternalType('string', (string) $object);
        $this->assertEquals($time->format("Y-m-d H:i:s"), (string) $object);
    }
}