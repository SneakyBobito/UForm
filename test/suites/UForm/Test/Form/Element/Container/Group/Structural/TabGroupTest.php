<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Container\Group\Structural;

use UForm\Form\Element\Container\Group\Structural\Tab;
use UForm\Form\Element\Container\Group\Structural\TabGroup;
use UForm\Form\Element\Primary\Input\Text;

class TabGroupTest extends \PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {
        $group = new TabGroup();
        $this->assertTrue($group->hasSemanticType("tabGroup"));
    }


    public function testAddElement()
    {
        $group = new TabGroup();
        $child = new Tab();

        $group->addElement($child);
        $this->assertSame($child, $group->getElements()[0]);

        $this->setExpectedException("UForm\InvalidArgumentException");
        $group->addElement(new Text("name"));
    }
}
