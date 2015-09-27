<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Container\Group;

use UForm\Form\Element\Container\Group\CheckGroup;

class CheckGroupTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var CheckGroup
     */
    protected $checkGroup;

    public function testConstruct()
    {
        $checkgroup = new CheckGroup(
            "checkGroup",
            [
                "one" => "One",
                "two" => "Two",
                "three" => "Three",
            ]
        );
        $elements = $checkgroup->getElements();

        $this->assertCount(3, $elements);

        foreach ($elements as $element) {
            $this->assertInstanceOf("UForm\Form\Element\Primary\Input\Check", $element);
        }

        $this->assertEquals("one", $elements[0]->getName());
        $this->assertEquals("two", $elements[1]->getName());
        $this->assertEquals("three", $elements[2]->getName());

        $this->assertEquals("One", $elements[0]->getValue());
        $this->assertEquals("Two", $elements[1]->getValue());
        $this->assertEquals("Three", $elements[2]->getValue());
    }
}
