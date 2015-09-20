<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test;

class InvalidArgumentExceptionTest extends \PHPUnit_Framework_TestCase
{

    public function testException()
    {
        // Just test that it creates without error
        $a = "string";
        $exception = new \UForm\InvalidArgumentException("a", "array", $a, "A string is not an array");
        $message = $exception->getMessage();
        $this->assertRegExp("/A string is not an array/", $message);
    }
}
