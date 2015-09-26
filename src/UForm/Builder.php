<?php

namespace UForm;

use UForm\Builder\FilterBuilder;
use UForm\Builder\FluentElement;
use UForm\Builder\GroupBuilder;
use UForm\Builder\InputBuilder;
use UForm\Builder\ValidatorBuilder;
use UForm\Form\Element;
use UForm\Validator;

class Builder
{
    use FluentElement;
    use GroupBuilder;
    use InputBuilder;
    use FilterBuilder;
    use ValidatorBuilder;

    /**
     * @var Form
     */
    protected $form;

    public function __construct($action = null, $method = null)
    {
        $this->form = new Form($action, $method);
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
     * @param null $action
     * @param null $method
     * @return self
     */
    public static function init($action = null, $method = null)
    {
        return new self($action, $method);
    }
}
