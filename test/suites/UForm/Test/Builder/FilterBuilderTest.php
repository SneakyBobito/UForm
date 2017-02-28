<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Builder;

use UForm\Builder;
use UForm\Filter\BoolToInt;
use UForm\Filter\Trim;
use UForm\Form\Element\Container\Group;

class FilterBuilderTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Builder\FilterBuilder
     */
    protected $filterBuilder;


    public function setUp()
    {
        $this->filterBuilder = new Builder();
    }

    public function testFilter()
    {
        $filter = new Trim();
        $this->filterBuilder->text('text');
        $this->filterBuilder->filter($filter);

        $this->assertSame($filter, $this->filterBuilder->last()->getFilters()[0]);
    }


    public function testTrim()
    {
        $this->filterBuilder->text('text');
        $this->filterBuilder->trim();

        $this->assertInstanceOf(Trim::class, $this->filterBuilder->last()->getFilters()[0]);
    }

    public function testBoolToInt()
    {
        $this->filterBuilder->text('text');
        $this->filterBuilder->boolToInt();

        $this->assertInstanceOf(BoolToInt::class, $this->filterBuilder->last()->getFilters()[0]);
    }
}
