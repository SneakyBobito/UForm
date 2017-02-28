<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Filter;

use UForm\Filter\BoolToInt;

/**
 * @covers UForm\Filter\BoolToInt
 */
class BoolToIntTest extends \PHPUnit_Framework_TestCase
{

    public function testFilter()
    {
        $filter = new BoolToInt();

        $this->assertEquals(1, $filter->filter(true));
        $this->assertEquals(0, $filter->filter(false));
        $this->assertEquals(0, $filter->filter(null));
        $this->assertEquals(0, $filter->filter(''));
        $this->assertEquals(1, $filter->filter('a'));
    }
}
