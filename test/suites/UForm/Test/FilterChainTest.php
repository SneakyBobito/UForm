<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test;

use UForm\Filter\RemoveValue;
use UForm\Filtering\FilterChain;

/**
 * @covers \UForm\FilterChain
 */
class FilterChainTest extends \PHPUnit_Framework_TestCase
{
    public function testRemoveValueIsRemoved()
    {
        $filterChain = new FilterChain();
        $filterChain->addFiltersFor('foo', [new RemoveValue()]);

        $data = $filterChain->sanitizeData(['foo' => 'bar'], true);

        $this->assertCount(0, $data);
    }
}
