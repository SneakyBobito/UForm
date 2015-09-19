<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Filter;

use UForm\Filter\LeftTrim;

class LeftTrimTest extends \PHPUnit_Framework_TestCase
{

    public function testFilter()
    {
        $filter = new LeftTrim();
        $this->assertEquals("foo ", $filter->filter(" foo "));

        $filter = new LeftTrim("-+");
        $this->assertEquals("foo+-+", $filter->filter("+-+foo+-+"));
    }
}
