<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Primary\Input;

use UForm\Form\Element\Primary\Input;
use UForm\Form\Element\Primary\Input\Hidden;

class HiddenTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Input
     */
    protected $input;

    public function setUp()
    {
        $this->input = new Hidden("inputname", "inputValue");
    }

    public function testConstruct()
    {
        $this->assertTrue($this->input->hasSemanticType("input:hidden"));
    }

    public function testRender()
    {
        $render = $this->input->render(["inputname" => "inputFakeValue"]);
        $id = $this->input->getId();
        $expected = '<input type="hidden" name="inputname" id="' . $id . '" value="inputValue"/>';
        $this->assertEquals($expected, $render);
    }
}
