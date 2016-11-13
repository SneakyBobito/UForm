<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Render;

use UForm\Builder;
use UForm\Render\AbstractHtmlRender as AbstractRender;

class TwigExtensionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var AbstractRender
     */
    protected $render;

    public function setUp()
    {
        $this->render = $this->getMockForAbstractClass('UForm\Render\AbstractHtmlRender');
        $this->render
            ->method('getTemplatesPaths')
            ->willReturn(['test' => __DIR__ . '/../../../../Fixtures/templates/TwigExtension']);
    }


    public function testRenderParentType()
    {
        $expected = '<renderParentType>action:someAction</renderParentType>';
        $form = Builder::init('someAction')->getForm();
        $actual = $this
            ->render
            ->renderElementAs($form, $form->generateContext(), ['renderParentType', 'renderParentType.parent']);
        $this->assertEquals($expected, $actual);
    }

    public function testRenderElement()
    {
        $expected = '<renderElement>text:textName</renderElement>';
        $form = Builder::init('someAction')->text('textName')->getForm();
        $actual = $this->render->renderElementAs($form, $form->generateContext(), ['renderElement']);
        $this->assertEquals($expected, $actual);
    }

    public function testDefaultRenderFor()
    {
        $form = Builder::init('someAction')->text('textName')->getForm();
        $id = $form->getElement('textName')->getId();

        $expected = '<defaultRenderFor><input type="text" name="textName" id="' . $id . '"/></defaultRenderFor>';
        $actual = $this->render->renderElementAs($form, $form->generateContext(), ['defaultRenderFor']);
        $this->assertEquals($expected, $actual);
    }
}
