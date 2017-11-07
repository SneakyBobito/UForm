<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Primary\Input;

use UForm\Form\Element\Drawable;
use UForm\Form\Element\Primary;
use UForm\Form\Element\Primary\Input;
use UForm\Form\Element\Primary\Input\Text;

class NumberTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Input
     */
    protected $input;

    public function setUp()
    {
        $this->input = new Input\Number('inputname');
    }

    public function testConstruct()
    {
        $this->assertTrue($this->input->hasSemanticType('input:number'));
    }

    public function testRender()
    {
        $this->input->setAttribute('foo', 'bar');
        $render = $this->input->render(['inputname' => 'inputValue'], ['inputname' => 'inputValue']);
        $id = $this->input->getId();
        $expected = '<input type="number" name="inputname" id="' . $id . '" foo="bar" value="inputValue"/>';
        $this->assertEquals($expected, $render);
    }
}
