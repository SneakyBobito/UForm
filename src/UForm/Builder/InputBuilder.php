<?php
/**
 * @license see LICENSE
 */

namespace UForm\Builder;

use UForm\Filter\BooleanValue;
use UForm\Filter\DefaultValue;
use UForm\Form\Element;
use UForm\Form\Element\Container\Group;
use UForm\Form\Element\Primary\Input\Check;
use UForm\Form\Element\Primary\Input\File;
use UForm\Form\Element\Primary\Input\Hidden;
use UForm\Form\Element\Primary\Input\Password;
use UForm\Form\Element\Primary\Input\Submit;
use UForm\Form\Element\Primary\Input\Text;
use UForm\Form\Element\Primary\Select;
use UForm\Form\Element\Primary\TextArea;

trait InputBuilder
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
    abstract public function open(Group $e);

    /**
     * @see FluentElement::close()
     * @return $this
     */
    abstract public function close();

    /**
     * @see FluentElement::last()
     * @return $this
     */
    abstract public function last();

    /**
     * @see FluentElement::current()
     * @return $this
     */
    abstract public function current();

    /**
     * Binds the given input with its title
     * @param Element $element
     * @param $label
     */
    protected function _makeInput(Element $element, $label, $defaultValue)
    {
        if (null !== $label) {
            $element->setOption("label", $label);
        }

        if (null !== $defaultValue) {
            $element->addFilter(new DefaultValue($defaultValue));
        }
    }

    /**
     * creates an input text
     * @see UForm\Form\Element\Primary\Text
     * @param $name
     * @param $label
     * @return $this
     */
    public function text($name, $label = null, $defaultValue = null)
    {
        $element = new Text($name);
        $this->_makeInput($element, $label, $defaultValue);
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
    public function textArea($name, $label = null, $defaultValue = null)
    {
        $element = new TextArea($name);
        $this->_makeInput($element, $label, $defaultValue);
        $this->add($element);
        return $this;
    }


    /**
     * @see UForm\Form\Element\Primary\Input\Password
     * @param $name
     * @param $label
     * @return $this
     */
    public function password($name, $label = null, $defaultValue = null)
    {
        $element = new Password($name);
        $this->_makeInput($element, $label, $defaultValue);
        $this->add($element);

        return $this;
    }

    /**
     * @see UForm\Form\Element\Primary\Select
     * @param $name
     * @param $label
     * @return $this
     */
    public function select($name, $label, $values = [], $defaultValue = null)
    {
        $element = new Select($name, $values);
        $this->_makeInput($element, $label, $defaultValue);
        $this->add($element);
        return $this;
    }

    /**
     * @see UForm\Form\Element\Primary\Input\Hidden
     * @param $name
     * @return $this
     */
    public function hidden($name, $value = null, $defaultValue = null)
    {
        $element = new Hidden($name, $value, $defaultValue);
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
        $this->_makeInput($element, $label, null);
        $this->add($element);
        return $this;
    }

    /**
     * add a submit input to the current group
     * @see UForm\Form\Element\Primary\Input\Submit
     * @return $this
     */
    public function submit()
    {
        $element = new Submit();
        $this->add($element);
        return $this;
    }

    /**
     * add a check input to the current group
     * @see UForm\Form\Element\Primary\Input\Check
     * @param $label
     * @param boolean $checkedDefault pass it to true to set the checkbox checked
     * @param null $name
     * @return $this
     */
    public function check($name, $label, $checkedDefault = null)
    {
        $element = new Check($name);
        $this->_makeInput($element, $label, $checkedDefault);
        $element->addFilter(new BooleanValue());
        $this->add($element);
        return $this;
    }



    public function checkGroup($name)
    {
        $element = new Group\CheckGroup($name, []);
        $this->add($element);
        $this->open($element);
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
