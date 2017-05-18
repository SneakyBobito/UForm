<?php
/**
 * @license see LICENSE
 */

namespace UForm\Builder;

use UForm\Filter\BooleanValue;
use UForm\Filter\DefaultValue;
use UForm\Filter\FreezeValue;
use UForm\Filter\RemoveValue;
use UForm\Form\Element;
use UForm\Form\Element\Container\Group;
use UForm\Form\Element\Primary\Input\Check;
use UForm\Form\Element\Primary\Input\File;
use UForm\Form\Element\Primary\Input\Hidden;
use UForm\Form\Element\Primary\Input\Password;
use UForm\Form\Element\Primary\Input\Radio;
use UForm\Form\Element\Primary\Input\Submit;
use UForm\Form\Element\Primary\Input\Text;
use UForm\Form\Element\Primary\Select;
use UForm\Form\Element\Primary\TextArea;
use UForm\Validator\File\MimeType;
use UForm\Validator\IsFile;
use UForm\Validator\IsValid;

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
     * @return Element
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
            $element->setOption('label', $label);
        }

        if (null !== $defaultValue) {
            $element->addFilter(new DefaultValue($defaultValue));
        }
    }

    /**
     * creates an input text
     * @see \UForm\Form\Element\Primary\Text
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
     * @see \UForm\Form\Element\Primary\Input\Text
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
     * @see \UForm\Form\Element\Primary\Input\Password
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
     * @see Select
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
     * @see Select
     * @param $name
     * @param $label
     * @return $this
     */
    public function selectMultiple($name, $label, $values = [], $defaultValue = null)
    {
        $element = new Select($name, $values, true);
        $this->_makeInput($element, $label, $defaultValue);
        $this->add($element);
        return $this;
    }

    /**
     * @see \UForm\Form\Element\Primary\Input\Hidden
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
     * @see \UForm\Form\Element\Primary\Input\File
     * @param $name
     * @param $label
     * @return $this
     */
    public function file($name, $label = null, $multiple = false, array $allowMimeTypes = null)
    {
        if ($allowMimeTypes & !empty($allowMimeTypes)) {
            $accept = implode(',', $allowMimeTypes);
        } else {
            $accept = null;
        }

        $element = new File($name, $multiple, $accept);
        $this->_makeInput($element, $label, null);
        $this->add($element);

        if ($accept) {
            $this->validator(new MimeType($allowMimeTypes));
        }

        return $this;
    }

    /**
     * add a submit input to the current group
     * @see \UForm\Form\Element\Primary\Input\Submit
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
     * @see \UForm\Form\Element\Primary\Input\Check
     * @param $label
     * @param boolean $checkedDefault pass it to true to set the checkbox checked
     * @param null $name
     * @return $this
     */
    public function check($name, $label, $checkedDefault = null)
    {
        $element = new Check($name);
        $this->_makeInput($element, $label, $checkedDefault == true);
        $element->addFilter(new BooleanValue());
        $this->add($element);
        return $this;
    }


    /**
     * Adds a radio to the current element
     *
     * radio must have a radio group as ancestor, but not necessary as a direct parent
     *
     * @see \UForm\Form\Element\Container\Group\Proxy\RadioGroup
     * @param string $name name of the radio
     * @param string $value value of the radio
     * @param string $label  label of the radio. If null it will take the value of the radio as label
     * @return $this
     */
    public function radio($name, $value, $label = null)
    {
        if (null == $label) {
            $label = $value;
        }
        $element = new Radio($name, $value);
        $this->_makeInput($element, $label, null);
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
            $this->last()->setOption('leftAddon', $text);
        } catch (BuilderException $e) {
            throw new BuilderException('leftAddon() call requires you already added an element to the builder', 0, $e);
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
            $this->last()->setOption('rightAddon', $text);
        } catch (BuilderException $e) {
            throw new BuilderException('rightAddon() call requires you already added an element to the builder', 0, $e);
        }
        return $this;
    }

    /**
     * Set the last element to be readonly
     *
     * @param string $value a value to set for the field.
     * This value will automatically replace the previous @see \UForm\Filter\FreezeValue
     * If omitted then the original value will be removed @see \UForm\Filter\RemoveValue
     * @return $this
     */
    public function readOnly($value = null)
    {
        if ($value !== null) {
            $this->last()->addFilter(new FreezeValue($value));
        } else {
            $this->last()->addFilter(new RemoveValue());
        }
        $this->last()->setAttribute('readonly', 'readonly');
        return $this;
    }

    /**
     * Set the last element disabled.
     * The value will be removed @see \UForm\Filter\RemoveValue
     * @return $this
     */
    public function disabled()
    {
        $this->last()->addFilter(new RemoveValue());
        $this->last()->setAttribute('disabled', 'disabled');
        return $this;
    }

    /**
     * Set an attribute on the last element added
     * @param $name
     * @param $value
     * @return $this
     */
    public function attribute($name, $value)
    {
        $this->last()->setAttribute($name, $value);
        return $this;
    }
}
