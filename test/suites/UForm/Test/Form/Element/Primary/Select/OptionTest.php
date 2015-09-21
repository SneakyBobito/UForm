<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Primary\Select;

use UForm\Form\Element\Primary\Select\Option;

class OptionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Option
     */
    protected $option;

    public function setUp(){
        $this->option = new Option("optionValue", "optionLabel");
    }

    public function testConstruct()
    {
        $option = new Option("optionValue", "optionLabel");
        $this->assertEquals("optionValue", $option->getValue());
        $this->assertEquals("optionLabel", $option->getLabel());
    }

    public function testEnable(){
        $this->assertTrue($this->option->isEnabled());
        $this->option->disable();
        $this->assertFalse($this->option->isEnabled());
        $this->option->disable(); // double disable
        $this->assertFalse($this->option->isEnabled());
        $this->option->enable();
        $this->assertTrue($this->option->isEnabled());
        $this->option->enable(); // Double enable
        $this->assertTrue($this->option->isEnabled());
    }

    public function testRender(){
        $expected = '<option value="optionValue">optionLabel</option>';
        $this->assertEquals($expected, $this->option->render(null));

        $expected = '<option value="optionValue" selected="selected">optionLabel</option>';
        $this->assertEquals($expected, $this->option->render("optionValue"));

        $this->option->disable();
        $expected = '<option value="optionValue" disabled="disabled">optionLabel</option>';
        $this->assertEquals($expected, $this->option->render("optionValue"));
    }
}
