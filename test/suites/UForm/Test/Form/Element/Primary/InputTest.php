<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Primary;

use UForm\Form\Element\Primary\Input;

class InputTest extends \PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {
        /* @var $input Input */
        $input = $this->getMockForAbstractClass("UForm\Form\Element\Primary\Input", ["inputType", "inputName"]);

        $this->assertTrue($input->hasSemanticType("input"));
        $this->assertTrue($input->hasSemanticType("input:inputType"));
    }

    public function testRender()
    {
        /* @var $input Input */
        $input = $this->getMockForAbstractClass("UForm\Form\Element\Primary\Input", ["inputType", "inputName"]);
        $expected = '<input type="inputType" name="inputName" value="someValue"/>';
        $this->assertEquals($expected, $input->render(["inputName" => "someValue"], ["inputName" => "someValue"]));
    }
}
