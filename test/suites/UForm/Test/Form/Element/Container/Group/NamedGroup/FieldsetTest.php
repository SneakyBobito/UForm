<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Container\Group\NamedGroup;

use UForm\Form\Element\Container\Group\NamedGroup\Fieldset;

class FieldsetTest extends \PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {
        $group = new Fieldset("myTitle", "myName");

        $this->assertEquals("myTitle", $group->getOption("title"));
        $this->assertEquals("myName", $group->getName("title"));
        $this->assertTrue($group->hasSemanticType("fieldset"));
    }
}
