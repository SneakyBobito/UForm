<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Primary\Input;


use UForm\Form\Element\Primary\Input;
use UForm\Form\Element\Primary\Input\Submit;

class SubmitTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Input
     */
    protected $input;

    public function setUp(){
        $this->input = new Submit("inputname");
    }

    public function testConstruct(){
        $this->assertTrue($this->input->hasSemanticType("input:submit"));
    }

    public function testRender(){
        $render = $this->input->render(["inputname" => "inputValue"], ["inputname" => "inputValue"]);

        $expected = '<input type="submit" name="inputname" value="inputValue"/>';
        $this->assertEquals($expected, $render);
    }

}
