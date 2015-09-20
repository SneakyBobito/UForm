<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Container\Group\NamedGroup;


use UForm\Form\Element\Container\Group;
use UForm\Form\Element\Container\Group\ColumnGroup;
use UForm\Form\Element\Container\Group\NamedGroup\Column;

class ColumnTest extends \PHPUnit_Framework_TestCase {

    public function testConstruct(){
        $column = new Column(5);

        $this->assertSame(5, $column->getWidth());
        $this->assertTrue($column->hasSemanticType("column"));

        $this->setExpectedException("UForm\Exception");
        new Column(-2);
    }

    public function testSetParent(){
        $columnGroup = new ColumnGroup();
        $column = new Column(5);
        $column->setParent($columnGroup);

        $this->assertSame($columnGroup, $column->getParent());

        $this->setExpectedException("UForm\Exception");
        $column->setParent(new Group());
    }

    public function testGetAdaptiveWidth(){

        // No parent
        $column = new Column(5);
        $this->assertEquals(10, $column->getAdaptiveWidth(10));


        // With parent
        $columnGroup = $this->getMockBuilder("UForm\Form\Element\Container\Group\ColumnGroup")->getMock();
        $column->setParent($columnGroup);
        $columnGroup->method("getWidthInPercent")->willReturn(100);
        $this->assertEquals(10, $column->getAdaptiveWidth(10));
        $this->assertEquals(12, $column->getAdaptiveWidth(12));

        // mock other children in parent
        $columnGroup = $this->getMockBuilder("UForm\Form\Element\Container\Group\ColumnGroup")->getMock();
        $columnGroup->method("getWidthInPercent")->willReturn(50);
        $column->setParent($columnGroup);
        $this->assertEquals(6, $column->getAdaptiveWidth(12));

        $columnGroup = $this->getMockBuilder("UForm\Form\Element\Container\Group\ColumnGroup")->getMock();
        $columnGroup->method("getWidthInPercent")->willReturn(25);
        $column->setParent($columnGroup);
        $this->assertEquals(3, $column->getAdaptiveWidth(12));


        $this->setExpectedException("UForm\InvalidArgumentException");
        $column->getAdaptiveWidth("fake");
    }


}
