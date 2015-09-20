<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Primary\Input;

use UForm\Form\Element\Primary\Input;
use UForm\Form\Element\Primary\Input\Password;

class PasswordTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Input
     */
    protected $input;

    public function setUp()
    {
        $this->input = new Password("inputname");
    }

    public function testConstruct()
    {
        $this->assertTrue($this->input->hasSemanticType("input:password"));
    }

    public function testRender()
    {
        $render = $this->input->render(["inputname" => "inputValue"], ["inputname" => "inputValue"]);

        $expected = '<input type="password" name="inputname" value="inputValue"/>';
        $this->assertEquals($expected, $render);
    }
}
