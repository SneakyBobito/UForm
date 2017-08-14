<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Primary\Input;

use UForm\Form\Element\Primary\Input;
use UForm\Form\Element\Primary\Input\Password;

class ColorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Input
     */
    protected $input;

    public function setUp()
    {
        $this->input = new Input\Color('inputname');
    }

    public function testConstruct()
    {
        $this->assertTrue($this->input->hasSemanticType('input:color'));
    }

    public function testRender()
    {
        $render = $this->input->render(['inputname' => 'inputValue'], ['inputname' => 'inputValue']);
        $id = $this->input->getId();

        $expected = '<input type="color" name="inputname" id="' . $id . '" value="inputValue"/>';
        $this->assertEquals($expected, $render);
    }
}
