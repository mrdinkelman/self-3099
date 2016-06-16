<?php
/**
 * Created by PhpStorm.
 * User: a2.ilin
 * Date: 15/06/16
 * Time: 19:34
 */

namespace ImportBundle\Tests;


use ImportBundle\Filters\BaseFilter;

class BaseFilterTest extends \PHPUnit_Framework_TestCase
{
    /** @var $tester BaseFilter */
    protected $tester;

    public function setUp()
    {
        $this->tester = new BaseFilter();
    }

    public function testReason()
    {
        $this->tester->setRejectReason('foo');
        $this->assertEquals("foo", $this->tester->getRejectReason());
    }

}
