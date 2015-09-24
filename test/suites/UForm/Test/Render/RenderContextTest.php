<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Render;

use UForm\Builder;
use UForm\Form;
use UForm\Render\AbstractRender;
use UForm\Render\RenderContext;

class RenderContextTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var AbstractRender
     */
    protected $render;

    /**
     * @var Form
     */
    protected $form;


    public function setUp()
    {

        $this->render = $this->getMockForAbstractClass("UForm\Render\AbstractRender");
        $this->render
            ->method("getTemplatesPath")
            ->willReturn(__DIR__ . "/../../../../Fixtures/templates/AbstractRender");
        
        $this->form = Builder::init()->text("firstname")->text("lastname")->getForm();
        $this->form->getElement("firstname")->addValidator(function () {
            return false;
        });
    }

    /**
     * @return RenderContext
     */
    public function generateContext($elementName, $data)
    {
        return $this->render->generateRenderContext(
            $this->form->getElement($elementName),
            $this->form->validate([]),
            $data
        );
    }

    public function testIsValid()
    {

        $this->assertTrue($this->generateContext('lastname', [])->isValid());
        $this->assertFalse($this->generateContext('firstname', [])->isValid());

    }

    public function testElementDefaultRenderException()
    {
        $unrenderable = $this->getMockForAbstractClass("UForm\Form\Element", ["unrenderable"]);

        $context = $this->generateContext("firstname", []);
        $this->setExpectedException("UForm\Exception");
        $context->elementDefaultRender($unrenderable);
    }
}
