<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Primary;


use UForm\Form\Element\Primary\TextArea;

class TextAreaTest extends \PHPUnit_Framework_TestCase {

    public function testConstruct(){
        $textArea = new TextArea("textarea");
        $this->assertTrue($textArea->hasSemanticType("textarea"));
    }

    public function testRender(){
        $textArea = new TextArea("textarea");
        $expected = '<textarea name="textarea">some text</textarea>';
        $this->assertEquals($expected, $textArea->render(["textarea" => "some text"], ["textarea" => "some text"]));
    }

}
