<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Primary\Input;

use UForm\Form\Element\Primary\Input;
use UForm\Form\Element\Primary\Input\Radio;

/**
 * @covers UForm\Form\Element\Primary\Input\Radio
 */
class RadioTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Input
     */
    protected $input;

    public function setUp()
    {
        $this->input = new Radio("firstname", "bart");
    }

    public function testConstruct()
    {
        $this->assertTrue($this->input->hasSemanticType("input:radio"));
    }

    public function testRender()
    {
        $render = $this->input->render(["firstname" => "bart"]);
        $id = $this->input->getId();
        $expected = '<input type="radio" name="firstname" id="' . $id . '" value="bart" checked="checked"/>';
        $this->assertEquals($expected, $render);

        $render = $this->input->render(["firstname" => "homer"]);
        $id = $this->input->getId();
        $expected = '<input type="radio" name="firstname" id="' . $id . '" value="bart"/>';
        $this->assertEquals($expected, $render);
    }

    /**
     * Fix bug with boolean values that were not renderable as string
     */
    public function testBooleanValues(){

        $input = new Radio("something", true);

        $render = $input->render(["something" => true]);
        $id = $input->getId();
        $expected = '<input type="radio" name="something" id="' . $id . '" value="1" checked="checked"/>';
        $this->assertEquals($expected, $render);
    }
}
