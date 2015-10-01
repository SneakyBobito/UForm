<?php
/**
 * @license see LICENSE
 */

namespace UForm\Builder;

use UForm\Form\Element;
use UForm\Form\Element\Container\Group;
use UForm\Form\Element\Primary\Input\File;
use UForm\Form\Element\Primary\Input\Hidden;
use UForm\Form\Element\Primary\Input\Password;
use UForm\Form\Element\Primary\Input\Text;
use UForm\Form\Element\Primary\Select;
use UForm\Form\Element\Primary\TextArea;

trait InputBuilder
{

    abstract public function add(Element $e);
    abstract public function open(Group $e);
    abstract public function close();
    abstract public function last();
    abstract public function current();

    /**
     * Binds the given input with its title
     * @param Element $element
     * @param $label
     */
    protected function _makeInput(Element $element, $label)
    {
        if (null !== $label) {
            $element->setOption("label", $label);
        }
    }

    /**
     * creates an input text
     * @see UForm\Form\Element\Primary\Text
     * @param $name
     * @param $label
     * @return $this
     */
    public function text($name, $label = null)
    {
        $element = new Text($name);
        $this->_makeInput($element, $label);
        $this->add($element);

        return $this;
    }

    /**
     * creates a textarea
     * @see UForm\Form\Element\Primary\Input\Text
     * @param $name
     * @param $label
     * @return $this
     */
    public function textArea($name, $label = null)
    {
        $element = new TextArea($name);
        $this->_makeInput($element, $label);
        $this->add($element);
        return $this;
    }


    /**
     * @see UForm\Form\Element\Primary\Input\Password
     * @param $name
     * @param $label
     * @return $this
     */
    public function password($name, $label = null)
    {
        $element = new Password($name);
        $this->_makeInput($element, $label);
        $this->add($element);

        return $this;
    }

    /**
     * @see UForm\Form\Element\Primary\Select
     * @param $name
     * @param $label
     * @return $this
     */
    public function select($name, $label, $values = [])
    {
        $element = new Select($name, $values);
        $this->_makeInput($element, $label);
        $this->add($element);
        return $this;
    }

    /**
     * @see UForm\Form\Element\Primary\Input\Hidden
     * @param $name
     * @return $this
     */
    public function hidden($name)
    {
        $element = new Hidden($name);
        $this->add($element);
        return $this;
    }

    /**
     * @see UForm\Form\Element\Primary\Input\File
     * @param $name
     * @param $label
     * @return $this
     */
    public function file($name, $label = null)
    {
        $element = new File($name);
        $this->_makeInput($element, $label);
        $this->add($element);
        return $this;
    }

    /**
     * add a left addon option for current input
     * @param $text
     * @return $this
     * @throws BuilderException
     */
    public function leftAddon($text)
    {
        try {
            $this->last()->setOption("leftAddon", $text);
        } catch (BuilderException $e) {
            throw new BuilderException("leftAddon() call requires you already added an element to the builder", 0, $e);
        }
        return $this;
    }

    /**
     * add a rightAddon option for current input
     * @param $text
     * @return $this
     * @throws BuilderException
     */
    public function rightAddon($text)
    {
        try {
            $this->last()->setOption("rightAddon", $text);
        } catch (BuilderException $e) {
            throw new BuilderException("rightAddon() call requires you already added an element to the builder", 0, $e);
        }
        return $this;
    }
}
