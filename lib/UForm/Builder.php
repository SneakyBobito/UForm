<?php

namespace UForm;

use UForm\Builder\FluentElement;
use UForm\Builder\GroupBuilder;
use UForm\Builder\InputBuilder;
use UForm\Form\Element;
use UForm\Validator;

class Builder
{

    use FluentElement;
    use GroupBuilder;
    use InputBuilder;

    /**
     * @var Form
     */
    protected $form;

    public function __construct()
    {
        $this->form = new Form();
        $this->open($this->form);
    }

    /**
     * get the generated form
     * @return Form
     */
    public function getForm()
    {
        return $this->form;
    }







    /**
     * Add a required validator
     * @param string $text the  message to pass to the validator
     * @return $this
     */
    public function required($text = null)
    {
        if (null === $text) {
            $text = "Field Required";
        }
        $last = $this->last();
        $last->addRequiredValidator($text);
        $last->setUserOption("required", true);
        return $this;
    }

    /**
     * Add a required validator
     * @param string $text the  message to pass to the validator
     * @return $this
     */
    public function setOption($option, $value)
    {
        $last = $this->last();
        $last->setOption($option, $value);
        return $this;
    }


    /**
     * @param callable|Validator $validator
     * @return $this
     * @throws \Exception
     */
    public function validator($validator)
    {
        $this->last()->addValidator($validator);
        return $this;
    }

    /**
     * @param callable|Filter $filter
     * @return $this
     * @throws \Exception
     */
    public function filter($filter)
    {
        $this->last()->addFilter($filter);
        return $this;
    }
}
