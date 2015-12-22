<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Filter;

use UForm\Filter\RemoveValue;

/**
 * @covers UForm\Filter\RemoveValue
 */
class RemoveValueTest extends \PHPUnit_Framework_TestCase
{

    public function testFilter()
    {
        $data = ["firstname" => "bart", "lastname" => "simpson"];
        $filter = new RemoveValue();
        $filter->processFiltering($data, "firstname");
        $this->assertSame(["lastname" => "simpson"], $data);
    }
}
