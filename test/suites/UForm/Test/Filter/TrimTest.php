<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Filter;

use UForm\Filter\Trim;

class TrimTest extends \PHPUnit_Framework_TestCase
{

    public function testFilter()
    {
        $filter = new Trim();
        $this->assertEquals('foo', $filter->filter(' foo '));

        $filter = new Trim('-+');
        $this->assertEquals('foo', $filter->filter('+-+foo+-+'));

        $this->assertNull($filter->filter(null));
    }
}
