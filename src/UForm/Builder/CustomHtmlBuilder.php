<?php
/**
 * @license see LICENSE
 */

namespace UForm\Builder;

use UForm\Form\Element;
use UForm\Form\Element\Primary\SimpleHtmlElement;

trait CustomHtmlBuilder
{

    /**
     * @see FluentElement::add()
     * @return $this
     */
    abstract public function add(Element $e);

    /**
     * @see FluentElement::open()
     * @return $this
     */
    abstract public function open(Element\Container\Group $e);

    /**
     * @see FluentElement::close()
     * @return $this
     */
    abstract public function close();

    /**
     * @see FluentElement::last()
     * @return Element
     */
    abstract public function last();

    /**
     * @see FluentElement::current()
     * @return $this
     */
    abstract public function current();


    /**
     * @param $tagName
     * @param null $content
     * @return $this
     */
    public function simpleHtmlElement($tagName, $content = null)
    {
        $element = new SimpleHtmlElement($tagName, $content);
        $this->add($element);
        return $this;
    }

    /**
     * Add a custom html container
     * @param string $tag tagName of the html element
     * @param null|string $classes css classes to add to the element
     * @return $this
     */
    public function htmlContainer($tag, $classes = null)
    {
        $element = new Element\Container\HtmlContainer($tag);
        if ($classes) {
            $element->addClass($classes);
        }
        $this->add($element);
        $this->open($element);
        return $this;
    }

    public function hyperlink($value, $uri = null)
    {
        $this->simpleHtmlElement('a', $value);
        if ($uri) {
            $this->attribute('href', $uri);
        }
        return $this;
    }
}
