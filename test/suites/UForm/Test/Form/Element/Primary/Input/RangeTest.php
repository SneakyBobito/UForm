<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Primary\Input;

use UForm\Form\Element\Drawable;
use UForm\Form\Element\Primary;
use UForm\Form\Element\Primary\Input;
use UForm\Form\Element\Primary\Input\Text;

class RangeTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Input
     */
    protected $input;

    public function setUp()
    {
        $this->input = new Input\Range('inputname');
    }

    public function testConstruct()
    {
        $this->assertTrue($this->input->hasSemanticType('input:range'));
    }

    public function testRender()
    {
        $this->input->setAttribute('foo', 'bar');
        $render = $this->input->render(['inputname' => 1], ['inputname' => 1]);
        $id = $this->input->getId();
        $expected = '<input type="range" name="inputname" id="' . $id . '" foo="bar" value="1"/>';
        $this->assertEquals($expected, $render);


        $input = new Input\Range('foo', 12, 20, 1);
        $render = $input->render(['foo' => 18], ['foo' => 18]);
        $id = $input->getId();
        $expected = '<input type="range" name="foo" id="' . $id . '" min="12" max="20" step="1" value="18"/>';
        $this->assertEquals($expected, $render);
    }
}
