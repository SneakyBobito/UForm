<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Container;

use UForm\Form\Element\Container\HtmlContainer;
use UForm\Form\Element\Container\Group;
use UForm\Form\Element\Primary\Input\Text;
use UForm\Form\Element\Primary\SimpleHtmlElement;
use UForm\Tag;

/**
 * @covers \UForm\Form\Element\SimpleHtmlElement
 */
class SimpleHtmlElementTest extends \PHPUnit_Framework_TestCase
{

    public function testCustomHtml()
    {

        $html = new SimpleHtmlElement('a', 'foo');
        $html->addAttributes([
            'href' => '/bar',
        ]);

        $this->assertTrue($html->hasSemanticType('simpleHtmlElement'));

        $this->assertEquals('<a href="/bar">foo</a>', $html->render(null));
    }
}
