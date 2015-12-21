<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Primary;

use UForm\Form\Element\Primary\TextArea;

class TextAreaTest extends \PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {
        $textArea = new TextArea("textarea");
        $this->assertTrue($textArea->hasSemanticType("textarea"));
    }

    public function testRender()
    {
        $textArea = new TextArea("textarea");
        $textArea->setId("textAreaId");
        $expected = '<textarea name="textarea" id="textAreaId">some text</textarea>';
        $this->assertEquals($expected, $textArea->render(["textarea" => "some text"], ["textarea" => "some text"]));

        $expected = '<textarea name="textarea" id="textAreaId"></textarea>';
        $this->assertEquals($expected, $textArea->render(["fake" => "some text"], ["fake" => "some text"]));
    }
}
