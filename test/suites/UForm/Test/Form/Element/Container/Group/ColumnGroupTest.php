<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Container\Group;


use UForm\Form\Element\Container\Group\Column;
use UForm\Form\Element\Container\Group\ColumnGroup;
use UForm\Form\Element\Primary\Input\Text;

class ColumnGroupTest extends \PHPUnit_Framework_TestCase {

    public function testConstruct()
    {
        $group = new ColumnGroup();
        $this->assertTrue($group->hasSemanticType("columnGroup"));
    }


    public function testAddElement()
    {
        $group = new ColumnGroup();
        $child = new Column(5);

        $group->addElement($child);
        $this->assertSame($child, $group->getElements()[0]);

        $this->setExpectedException("UForm\InvalidArgumentException");
        $group->addElement(new Text("name"));
    }

    public function testGetWidthInPercent(){
        $group = new ColumnGroup();

        $this->assertEquals(100, $group->getWidthInPercent(20));
        $this->assertEquals(100, $group->getWidthInPercent(0));

        $group->addElement(new Column(100));
        $this->assertEquals(50, $group->getWidthInPercent(50));
        $group->addElement(new Column(100));
        $this->assertEquals(25, $group->getWidthInPercent(50));
        $group->addElement(new Column(50));
        $this->assertEquals(4, $group->getWidthInPercent(10));
    }

}
