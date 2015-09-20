<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Builder;

use UForm\Builder;
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
        $this->filterBuilder->text("text");
        $this->filterBuilder->filter($filter);

        $this->assertSame($filter, $this->filterBuilder->last()->getFilters()[0]);
    }
}
