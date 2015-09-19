<?php
/**
 * @license see LICENSE
 */

namespace UForm\Builder;

use UForm\Form\Element;
use UForm\Form\Element\Container\Group;
use UForm\Form\Element\Primary\Hidden;
use UForm\Form\Element\Primary\Password;
use UForm\Form\Element\Primary\RadioGroup;
use UForm\Form\Element\Primary\Select;
use UForm\Form\Element\Primary\Text;
use UForm\Form\Element\Primary\TextArea;

trait InputBuilder
{

    abstract public function add(Element $e);
    abstract public function open(Group $e);
    abstract public function close();
    abstract public function last();


    protected $useLabel = true;
    protected $usePlaceHolder = true;

    protected function _makeInput(Element $element, $hname)
    {
        if ($this->useLabel) {
            $element->setOption("label", $hname);
        }
        if ($this->usePlaceHolder) {
            $element->setAttribute("placeholder", $hname);
        }
    }

    /**
     * creates an input text
     * @see UForm\Form\Element\Primary\Text
     * @param $name
     * @param $hname
     * @return $this
     */
    public function text($name, $hname)
    {
        $element = new Text($name);
        $this->_makeInput($element, $hname);
        $this->add($element);

        return $this;
    }

    /**
     * creates a textarea
     * @see UForm\Form\Element\Primary\Text
     * @param $name
     * @param $hname
     * @return $this
     */
    public function textArea($name, $hname)
    {
        $element = new TextArea($name);
        $this->_makeInput($element, $hname);
        $this->add($element);
        return $this;
    }


    /**
     * Shortcut to create a yes/no radiogroup
     *
     * @see UForm\Form\Element\Primary\RadioGroup
     * @param $name
     * @param $hname
     * @param array $options
     * @return $this
     */
    public function yesNo($name, $hname, $options = [])
    {

        $yesText  = isset($options["yesText"]) ? $options["yestText"] : "Yes";
        $yesValue = isset($options["yesValue"]) ? $options["yesValue"] : 1;
        $noText = isset($options["noText"]) ? $options["noText"] : "No";
        $noValue = isset($options["noValue"]) ? $options["noValue"] : 0;

        $element = new RadioGroup($name, [
            $yesValue => $yesText,
            $noValue => $noText
        ]);

        $this->_makeInput($element, $hname);
        $this->add($element);

        return $this;
    }



    /**
     * @see UForm\Form\Element\Primary\Password
     * @param $name
     * @param $hname
     * @return $this
     */
    public function password($name, $hname)
    {
        $element = new Password($name);
        $this->_makeInput($element, $hname);
        $this->add($element);

        return $this;
    }

    /**
     * @see UForm\Form\Element\Primary\Select
     * @param $name
     * @param $hname
     * @return $this
     */
    public function select($name, $hname, $values = [])
    {
        $element = new Select($name, $values);
        $this->_makeInput($element, $hname);
        $this->add($element);
        return $this;
    }

    /**
     * @see UForm\Form\Element\Primary\Hidden
     * @param $name
     * @param $hname
     * @return $this
     */
    public function hidden($name, $hname)
    {
        $element = new Hidden($name);
        $this->add($element);
        return $this;
    }

    /**
     * @see UForm\Form\Element\Primary\File
     * @param $name
     * @param $hname
     * @return $this
     */
    public function file($name, $hname)
    {
        $element = new Hidden($name);
        $this->_makeInput($element, $hname);
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
