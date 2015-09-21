<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Primary\Select;


use UForm\Form\Element\Primary\Select\Option;
use UForm\Form\Element\Primary\Select\OptionGroup;

class OptionGroupTest extends \PHPUnit_Framework_TestCase {

    public function testConstruct(){
        $optionGroup = new OptionGroup("simpsons family", ["homer", "marge", "bart", "lisa"]);
        $this->assertCount(4, $optionGroup->getOptions());
        $this->assertEquals("simpsons family", $optionGroup->getLabel());
    }

    public function testAddOption(){
        $option = new Option("name");
        $optionGroup = new OptionGroup("groupName");
        $optionGroup->addOption($option);
        $this->assertSame($option, $optionGroup->getOptions()[0]);
    }

    public function testAddOptions(){

        // TODO

    }

}
