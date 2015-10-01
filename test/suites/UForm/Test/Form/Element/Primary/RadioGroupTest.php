<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Primary;

use UForm\Form\Element\Primary\RadioGroup;

class RadioGroupTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var RadioGroup
     */
    protected $radioGroup;

    public function setUp()
    {
        $this->radioGroup = new RadioGroup("remember", [1 => "yes", 0 => "no"]);
    }

    public function testConstruct()
    {
        $this->assertTrue($this->radioGroup->hasSemanticType("radioGroup"));
    }

    public function testGetValueRange()
    {
        $this->assertEquals([1, 0], $this->radioGroup->getValueRange());
    }

//
//    public function testRender()
//    {
//        $render = $this->radioGroup->render(["remember" => 1], ["remember" => 1]);
//
//
//        $expected =   '<label for="' . $id1 . '">yes</label>'
//                    . '<input type="radio" name="remember" id="' . $id1 . '" value="1" checked="checked"/>'
//                    . '<label for="' . $id2 . '">no</label>'
//                    . '<input type="radio" name="remember" id="' . $id2 . '" value="0"/>';
//
//        $this->assertEquals($expected, $render);
//
//    }
}
