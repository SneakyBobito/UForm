<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Primary\Input;

use UForm\Form\Element\Primary\Input\Check;

class CheckTest extends \PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {
        $input = new Check("inputname", "yes");
        $this->assertTrue($input->hasSemanticType("input:checkbox"));
    }

    public function testRender()
    {
        $input = new Check("inputname", "yes");
        $render = $input->render(["inputname" => "yes"], ["inputname" => "yes"]);
        $expected = '<input type="checkbox" name="inputname" value="yes" checked="checked"/>';
        $this->assertEquals($expected, $render);

        // no value
        $input = new Check("inputname");
        $render = $input->render(["inputname" => "yes"], ["inputname" => "yes"]);
        $expected = '<input type="checkbox" name="inputname"/>';
        $this->assertEquals($expected, $render);
    }

    public function testGetValue()
    {
        $input = new Check("inputname", "yes");
        $this->assertEquals("yes", $input->getValue());
    }
}
