<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Builder;

use UForm\Builder;
use UForm\Form\Element\Container\HtmlContainer;
use UForm\Form\Element\Primary\SimpleHtmlElement;

/**
 * @covers \UForm\Builder\CustomHtmlBuilder
 */
class CustomHtmlBuilderTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Builder\CustomHtmlBuilder
     */
    protected $builderStub;


    public function setUp()
    {
        $this->builderStub = new Builder();
    }

    public function testSimpleHtmlElement()
    {
        $builder = $this->builderStub->simpleHtmlElement('foo', 'bar');
        /* @var SimpleHtmlElement $last */
        $last = $this->builderStub->last();

        $this->assertSame($this->builderStub, $builder);
        $this->assertInstanceOf(SimpleHtmlElement::class, $last);

        $this->assertEquals('<foo>bar</foo>', $last->render(null));
    }

    public function testHtmlContainer()
    {
        $builder = $this->builderStub->htmlContainer('foo', 'bar baz');
        /* @var HtmlContainer $current */
        $current = $this->builderStub->current();
        $this->assertSame($this->builderStub, $builder);
        $this->assertInstanceOf(HtmlContainer::class, $current);

        $this->assertEquals('<foo class="bar baz">', $current->getTag()->open());
    }

    public function testHyperlink()
    {
        $builder = $this->builderStub->hyperlink('foo bar', '/baz');
        /* @var SimpleHtmlElement $last */
        $last = $this->builderStub->last();

        $this->assertSame($this->builderStub, $builder);
        $this->assertInstanceOf(SimpleHtmlElement::class, $last);

        $this->assertEquals('<a href="/baz">foo bar</a>', $last->render(null));
    }
}
