<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Filter;

use UForm\Filter\RightTrim;

class RightTrimTest extends \PHPUnit_Framework_TestCase
{

    public function testFilter()
    {
        $filter = new RightTrim();
        $this->assertEquals(" foo", $filter->filter(" foo "));

        $filter = new RightTrim("-+");
        $this->assertEquals("+-+foo", $filter->filter("+-+foo+-+"));

        $this->assertNull($filter->filter(null));
    }
}
