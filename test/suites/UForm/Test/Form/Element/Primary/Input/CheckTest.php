<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Primary\Input;

use UForm\Form\Element\Primary\Input\Check;

/**
 * @covers UForm\Form\Element\Primary\Input\Check
 */
class CheckTest extends \PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {
        $input = new Check("inputname");
        $this->assertTrue($input->hasSemanticType("input:checkbox"));
    }

    public function testRender()
    {
        $input = new Check("inputname", "yes");
        $id = $input->getId();
        $render = $input->render(["inputname" => true]);
        $expected = '<input type="checkbox" name="inputname" id="' . $id . '" value="1" checked="checked"/>';
        $this->assertEquals($expected, $render);

        // no value
        $input = new Check("inputname");
        $id = $input->getId();
        $render = $input->render(["inputname" => false]);
        $expected = '<input type="checkbox" name="inputname" id="' . $id . '" value="1"/>';
        $this->assertEquals($expected, $render);
    }
}
