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
}
