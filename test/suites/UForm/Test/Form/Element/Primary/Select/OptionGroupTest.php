<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Primary\Select;

use UForm\Form\Element\Primary\Select\Option;
use UForm\Form\Element\Primary\Select\OptionGroup;

class OptionGroupTest extends \PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {
        $optionGroup = new OptionGroup("simpsons family", ["homer", "marge", "bart", "lisa"]);
        $this->assertCount(4, $optionGroup->getOptions());
        $this->assertEquals("simpsons family", $optionGroup->getLabel());
    }

    public function testAddOption()
    {
        $option = new Option("name");
        $optionGroup = new OptionGroup("groupName");
        $optionGroup->addOption($option);
        $this->assertSame($option, $optionGroup->getOptions()[0]);
    }

    public function testAddOptions()
    {

        // Test text only
        $optionGroup = new OptionGroup("groupName");
        $optionGroup->addOptions(["homer", "marge"]);
        $optionGroup->getOptions();
        $this->assertEquals("homer", $optionGroup->getOptions()[0]->getValue());
        $this->assertEquals("marge", $optionGroup->getOptions()[1]->getValue());
        $this->assertNull($optionGroup->getOptions()[0]->getLabel());
        $this->assertNull($optionGroup->getOptions()[1]->getLabel());


        // Test Text and key
        $optionGroup = new OptionGroup("groupName");
        $optionGroup->addOptions(["Homer" => "homer", "Marge" => "marge"]);
        $optionGroup->getOptions();
        $this->assertEquals("homer", $optionGroup->getOptions()[0]->getValue());
        $this->assertEquals("marge", $optionGroup->getOptions()[1]->getValue());
        $this->assertEquals("Homer", $optionGroup->getOptions()[0]->getLabel());
        $this->assertEquals("Marge", $optionGroup->getOptions()[1]->getLabel());

        // Test option instances
        $optionGroup = new OptionGroup("groupName");
        $homer = new Option("homer");
        $marge = new Option("marge");
        $optionGroup->addOptions([$homer, $marge]);
        $optionGroup->getOptions();

        $this->assertSame($homer, $optionGroup->getOptions()[0]);
        $this->assertSame($marge, $optionGroup->getOptions()[1]);

        try {
            $optionGroup->addOptions([new \stdClass()]);
            $this->fail("Exception not thrown");
        } catch (\UForm\Exception $e) {
            $this->assertTrue(true);
        }

        try {
            $optionGroup->addOptions([[]]);
            $this->fail("Exception not thrown");
        } catch (\UForm\Exception $e) {
            $this->assertTrue(true);
        }

    }
}
