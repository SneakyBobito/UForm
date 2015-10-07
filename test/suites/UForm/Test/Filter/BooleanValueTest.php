<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Filter;

use UForm\Filter\BooleanValue;

/**
 * @covers UForm\Filter\BooleanValue
 */
class BooleanValueTest extends \PHPUnit_Framework_TestCase
{

    public function testFilter()
    {
        $filter = new BooleanValue();

        $this->assertTrue($filter->filter("a"));
        $this->assertTrue($filter->filter(1));
        $this->assertTrue($filter->filter(2));
        $this->assertTrue($filter->filter(true));
        $this->assertTrue($filter->filter("true"));
        $this->assertTrue($filter->filter(0.1));

        $this->assertFalse($filter->filter(""));
        $this->assertFalse($filter->filter("0"));
        $this->assertFalse($filter->filter([]));
        $this->assertFalse($filter->filter(0));
        $this->assertFalse($filter->filter(-1));
        $this->assertFalse($filter->filter(false));
        $this->assertFalse($filter->filter("false"));
        $this->assertFalse($filter->filter(null));
        $this->assertFalse($filter->filter("null"));
        $this->assertFalse($filter->filter(0.0));
        $this->assertFalse($filter->filter(-0.1));

    }
}
