<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Primary\Input;

use UForm\Form\Element\Primary\Input;
use UForm\Form\Element\Primary\Input\Submit;

class SubmitTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Input
     */
    protected $input;

    public function setUp()
    {
        $this->input = new Submit('inputname');
    }

    public function testConstruct()
    {
        $this->assertTrue($this->input->hasSemanticType('input:submit'));
    }

    public function testRender()
    {
        $render = $this->input->render(['inputname' => 'inputValue'], ['inputname' => 'inputValue']);
        $id = $this->input->getId();
        $expected = '<input type="submit" name="inputname" id="' . $id . '" value="inputValue"/>';
        $this->assertEquals($expected, $render);
    }

    public function testRenderValue()
    {

        $submit = new Submit('foo', 'bar');
        $render = $submit->render(['foo' => 'inputValue']);
        $id = $submit->getId();

        $expected = '<input type="submit" name="foo" id="' . $id . '" value="bar"/>';
        $this->assertEquals($expected, $render);
    }
}
