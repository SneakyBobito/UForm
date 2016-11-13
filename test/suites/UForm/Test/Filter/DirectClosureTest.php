<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Filter;

use UForm\Filter\DirectClosure;

class DirectClosureTest extends \PHPUnit_Framework_TestCase
{

    public function testFilter()
    {
        $closure = function ($v) {
            return "-$v-";
        };
        $directClosure = new DirectClosure($closure);

        $this->assertSame($closure, $directClosure->getClosure());

        $this->assertEquals('-foo-', $directClosure->filter('foo'));
    }
}
