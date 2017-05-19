<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Container;

use UForm\Form\Element\Container\HtmlContainer;
use UForm\Form\Element\Container\Group;
use UForm\Form\Element\Primary\Input\Text;
use UForm\Tag;

/**
 * @covers \UForm\Form\Element\Container\HtmlContainer
 */
class HtmlContainerTest extends \PHPUnit_Framework_TestCase
{

    public function testCustomHtml()
    {

        $html = new HtmlContainer('div');

        $this->assertTrue($html->hasSemanticType('htmlContainer'));

        $tag = $html->getTag();

        $this->assertInstanceOf(Tag::class, $tag);
        $this->assertEquals('<div>', $tag->open());
    }
}
