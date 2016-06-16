<?php
namespace ImportBundle\Tests;

use Ddeboer\DataImport\Filter\FilterInterface;
use Ddeboer\DataImport\Reader\ArrayReader;
use ImportBundle\Filters\BaseFilter;
use ImportBundle\Workflow;

class WorkflowTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Workflow
     */
    protected $tester;

    public function setUp()
    {
        $reader = new ArrayReader();

        $this->tester = new Workflow($reader);
    }

    public function testFiltered()
    {
        $dummy = ['foo' => 'bar'];

        // ordinary success
        $filter = new UsualSuccessFilter();
        $queue = new \SplPriorityQueue();
        $queue->insert($filter, $filter->getPriority());

        $this->assertTrue($this->tester->filterItem($dummy, $queue));

        // ordinary failed
        $filter = new UsualFailedFilter();
        $queue = new \SplPriorityQueue();
        $queue->insert($filter, $filter->getPriority());

        $this->assertFalse($this->tester->filterItem($dummy, $queue));

        $property = new \ReflectionProperty($this->tester, 'filtered');
        $property->setAccessible(true);

        $this->assertNotEmpty($property->getValue($this->tester));
        $this->assertInternalType('array', $property->getValue($this->tester));
        $filtered = $property->getValue($this->tester);
        $value = array_pop($filtered);

        $this->assertEquals(Workflow::MESS_UNKNOWN_REASON, $value);

        // success base filter
        $filter = new SuccessFilter();
        $queue = new \SplPriorityQueue();
        $queue->insert($filter, $filter->getPriority());

        $this->assertTrue($this->tester->filterItem($dummy, $queue));

        // failed base filter
        $filter = new FailedFilter();
        $queue = new \SplPriorityQueue();
        $queue->insert($filter, $filter->getPriority());

        $this->assertFalse($this->tester->filterItem($dummy, $queue));

        $property = new \ReflectionProperty($this->tester, 'filtered');
        $property->setAccessible(true);

        $this->assertNotEmpty($property->getValue($this->tester));
        $this->assertInternalType('array', $property->getValue($this->tester));
        $filtered = $property->getValue($this->tester);
        $value = array_pop($filtered);

        $this->assertEquals('foo', $value);
    }

    public function testProcess()
    {
        $res = $this->tester->process();

        $property = new \ReflectionProperty($res, 'filtered');
        $property->setAccessible(true);

        $this->assertEmpty($property->getValue($res));
    }
}

class SuccessFilter extends BaseFilter implements FilterInterface
{
    public function filter(array $item)
    {
        return true;
    }

    public function getPriority()
    {
        return 0;
    }
}

class FailedFilter extends BaseFilter implements FilterInterface
{
    public function filter(array $item)
    {
        $this->setRejectReason('foo');

        return false;
    }

    public function getPriority()
    {
        return 0;
    }
}

class UsualSuccessFilter implements FilterInterface
{
    public function filter(array $item)
    {
        return true;
    }

    public function getPriority()
    {
        return 0;
    }
}

class UsualFailedFilter implements FilterInterface
{
    public function filter(array $item)
    {
        return false;
    }

    public function getPriority()
    {
        return 0;
    }
}
