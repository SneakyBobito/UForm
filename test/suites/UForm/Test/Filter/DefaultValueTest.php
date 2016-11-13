<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Filter;

use UForm\Filter\DefaultValue;

/**
 * @covers UForm\Filter\DefaultValue
 */
class DefaultValueTest extends \PHPUnit_Framework_TestCase
{

    public function testSetValue()
    {
        $filter = new DefaultValue('defaultValue');
        $this->assertSame('defaultValue', $filter->filter(null));
        $this->assertSame('otherValue', $filter->filter('otherValue'));
    }
}
