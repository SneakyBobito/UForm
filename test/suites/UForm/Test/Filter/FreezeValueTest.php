<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Filter;

use UForm\Filter\FreezeValue;

/**
 * @covers UForm\Filter\FreezeValue
 */
class FreezeValueTest extends \PHPUnit_Framework_TestCase
{

    public function testFilter()
    {
        $filter = new FreezeValue("frozen");
        $this->assertSame("frozen", $filter->filter(null));
        $this->assertSame("frozen", $filter->filter("otherValue"));
    }
}
