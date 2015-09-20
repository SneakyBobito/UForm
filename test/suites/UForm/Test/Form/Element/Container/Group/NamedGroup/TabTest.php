<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Container\Group\NamedGroup;


use UForm\Form\Element\Container\Group\NamedGroup\Tab;

class TabTest extends \PHPUnit_Framework_TestCase {

    public function testConstruct(){
        $group = new Tab("myTitle", "myName");

        $this->assertEquals("myTitle", $group->getOption("title"));
        $this->assertEquals("myName", $group->getName("title"));
        $this->assertTrue($group->hasSemanticType("tab"));
    }

}
