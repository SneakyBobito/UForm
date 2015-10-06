<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Primary\Select;

use UForm\Form\Element\Primary\Select;
use UForm\Form\Element\Primary\Select\OptGroup;
use UForm\Form\Element\Primary\Select\Option;

/**
 * @covers UForm\Form\Element\Primary\Select\OptGroup
 */
class OptGroupTest extends \PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {
        $optionGroup = new OptGroup("simpsons family", ["homer", "marge", "bart", "lisa"]);
        $this->assertCount(4, $optionGroup->getOptions());
        $this->assertEquals("simpsons family", $optionGroup->getLabel());
    }

    public function testAddOption()
    {
        $select = new Select("selectName");
        $option = new Option("name");
        $optionGroup = new OptGroup("groupName");
        $optionGroup->setSelect($select);
        $optionGroup->addOption($option);
        $this->assertSame($option, $optionGroup->getOptions()[0]);
        $this->assertSame($select, $option->getSelect());
    }

    public function testSetSelect()
    {
        $select = new Select("selectName");
        $option = new Option("optionName");
        $optionGroup = new OptGroup("groupName");
        $optionGroup->addOption($option);
        $this->assertNull($option->getSelect());
        $optionGroup->setSelect($select);
        // test that setSelect also set select to children
        $this->assertSame($select, $option->getSelect());
    }

    public function testAddOptions()
    {

        // Test text only
        $optionGroup = new OptGroup("groupName");
        $optionGroup->addOptions(["homer", "marge"]);
        $optionGroup->getOptions();
        $this->assertEquals("homer", $optionGroup->getOptions()[0]->getValue());
        $this->assertEquals("marge", $optionGroup->getOptions()[1]->getValue());
        $this->assertEquals("homer", $optionGroup->getOptions()[0]->getLabel());
        $this->assertEquals("marge", $optionGroup->getOptions()[1]->getLabel());


        // Test Text and key
        $optionGroup = new OptGroup("groupName");
        $optionGroup->addOptions(["Homer" => "homer", "Marge" => "marge"]);
        $optionGroup->getOptions();
        $this->assertEquals("homer", $optionGroup->getOptions()[0]->getValue());
        $this->assertEquals("marge", $optionGroup->getOptions()[1]->getValue());
        $this->assertEquals("Homer", $optionGroup->getOptions()[0]->getLabel());
        $this->assertEquals("Marge", $optionGroup->getOptions()[1]->getLabel());

        // Test option instances
        $optionGroup = new OptGroup("groupName");
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

        try {
            $optionGroup->addOptions([true]);
            $this->fail("Exception not thrown");
        } catch (\UForm\Exception $e) {
            $this->assertTrue(true);
        }

    }
}
