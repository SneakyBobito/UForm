<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Primary\Input;

use UForm\Form\Element\Drawable;
use UForm\Form\Element\Primary;
use UForm\Form\Element\Primary\Input;
use UForm\Form\Element\Primary\Input\Text;

class TextTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Input
     */
    protected $input;

    public function setUp()
    {
        $this->input = new Text('inputname');
    }

    public function testConstruct()
    {
        $this->assertTrue($this->input->hasSemanticType('input:text'));
    }

    public function testRender()
    {
        $this->input->setAttribute('foo', 'bar');
        $render = $this->input->render(['inputname' => 'inputValue'], ['inputname' => 'inputValue']);
        $id = $this->input->getId();
        $expected = '<input type="text" name="inputname" id="' . $id . '" foo="bar" value="inputValue"/>';
        $this->assertEquals($expected, $render);
    }

    public function testOptionHandler()
    {
        $this->input->addRenderOptionHandler(function ($localValues, $options, Primary $el) {
            if (isset($localValues[$el->getName()])) {
                if (!isset($options['attributes'])) {
                    $options['attributes'] = [];
                }
                    $options['attributes']['foo'] = $localValues[$el->getName()];
            }

            return $options;
        });
        $render = $this->input->render(['inputname' => 'inputValue'], ['inputname' => 'inputValue']);
        $id = $this->input->getId();
        $expected = '<input type="text" name="inputname" id="' . $id . '" foo="inputValue" value="inputValue"/>';
        $this->assertEquals($expected, $render);
    }
}
