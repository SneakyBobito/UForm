<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Render;


use UForm\Builder;
use UForm\Form;
use UForm\Form\Element\Primary\Input\Text;
use UForm\Render\AbstractRender;

class AbstractRenderTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var AbstractRender
     */
    protected $render;

    public function setUp(){
        $this->render = $this->getMockForAbstractClass("UForm\Render\AbstractRender");
        $this->render->method("getTemplatesPath")->willReturn(__DIR__ . "/../../../../Fixtures/testRenderTemplates");
    }

    public function testGetTwigEnvironment(){
        $this->assertInstanceOf("Twig_Environment", $this->render->getTwigEnvironment());
    }

    public function testRender(){
        $expected = '<form action="someAction"></form>';
        $form = Builder::init("someAction")->getForm();
        $this->assertEquals($expected, $this->render->render($form->generateContext()));
    }

    public function testRenderElementAs(){
        $expected = '<alternativeForm action="someAction"></alternativeForm>';
        $form = Builder::init("someAction")->getForm();
        $actual = $this->render->renderElementAs($form, $form->generateContext(), ["testRenderElementAs"]);
        $this->assertEquals($expected, $actual);
    }

    public function testRenderElement(){
        $expected = '<testRenderElement name="textName"></testRenderElement>';
        $form = Builder::init("someAction")->getForm();
        $input = new Text("textName");
        $input->addSemanticType("testRenderElement");
        $actual = $this->render->renderElement($input, $form->generateContext());
        $this->assertEquals($expected, $actual);
    }

    public function testUnresolvedTemplateException(){

        $form = Builder::init("someAction")->getForm();

        try{
            $this->render->renderElementAs($form, $form->generateContext(), ["fake"]);
            $this->fail();
        }catch (\Twig_Error_Loader $e){
            $this->assertTrue(true);
        }
        try{
            $this->render->renderElementAs($form, $form->generateContext(), ["fake", "fake2"]);
            $this->fail();
        }catch (\Twig_Error_Loader $e){
            $this->assertTrue(true);
        }
    }

}