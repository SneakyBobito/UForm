<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Container\Group;

use UForm\Form\Element\Container\Group\Row;

class RowTest extends \PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {
        $group = new Row("myName");

        $this->assertEquals("myName", $group->getName("title"));
        $this->assertTrue($group->hasSemanticType("row"));
    }
}
