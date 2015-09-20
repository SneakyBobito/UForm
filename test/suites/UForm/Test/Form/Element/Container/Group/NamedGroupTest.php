<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Container\Group;


class NamedGroupTest extends \PHPUnit_Framework_TestCase {

    public function testConstruct(){
        /* @var $namedGroup \UForm\Form\Element\Container\Group\NamedGroup */
        $namedGroup = $this->getMockForAbstractClass("UForm\Form\Element\Container\Group\NamedGroup", ["myTitle", "myName"]);
        $this->assertTrue($namedGroup->hasSemanticType("namedGroup"));
        $this->assertEquals("myTitle", $namedGroup->getOption("title"));
        $this->assertEquals("myName", $namedGroup->getName());
    }

}
