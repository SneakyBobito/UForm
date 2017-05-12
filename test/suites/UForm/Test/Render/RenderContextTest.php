<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Render;

use UForm\Builder;
use UForm\Form;
use UForm\Render\AbstractHtmlRender;
use UForm\Render\RenderContext;
use UForm\Validation\ValidationItem;

/**
 * @covers UForm\Render\RenderContext
 */
class RenderContextTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var AbstractHtmlRender
     */
    protected $render;

    /**
     * @var Form
     */
    protected $form;


    public function setUp()
    {

        $this->render = $this->getMockForAbstractClass(\UForm\Render\AbstractHtmlRender::class);
        $this->render
            ->method('getTemplatesPath')
            ->will($this->returnValue(__DIR__ . '/../../../../Fixtures/templates/AbstractRender'));

        $this->form = Builder::init()->text('firstname')->text('lastname')->getForm();
        $this->form->getElement('firstname')->addValidator(function (ValidationItem $v) {
            $v->setInvalid();
        });
    }

    /**
     * @return RenderContext
     */
    public function generateContext($elementName, $data)
    {
        if ($elementName instanceof Form\Element) {
            $element = $elementName;
        } else {
            $element = $this->form->getElement($elementName);
        }

        return $this->render->generateRenderContext(
            $element,
            $this->form->validate([]),
            $data
        );
    }

    public function testIsValid()
    {

        $this->assertTrue($this->generateContext('lastname', [])->isValid());
        $this->assertFalse($this->generateContext('firstname', [])->isValid());

        $this->assertTrue($this->generateContext($this->form, [])->isValid());
    }

    public function testElementDefaultRenderException()
    {
        $unrenderable = $this->getMockForAbstractClass('UForm\Form\Element', ['unrenderable']);

        $context = $this->generateContext('firstname', []);
        $this->setExpectedException('UForm\Exception');
        $context->elementDefaultRender($unrenderable);
    }
}
