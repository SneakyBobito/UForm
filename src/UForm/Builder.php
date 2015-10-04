<?php

namespace UForm;

use UForm\Builder\BuilderException;
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

    public function __construct($action = null, $method = null, $builderOptions = [])
    {
        $this->form = new Form($action, $method);
        $this->open($this->form);

        if (isset($builderOptions["csrf"]) && $builderOptions["csrf"]) {
            if ($builderOptions["csrf"] instanceof Validator\Csrf\CsrfInterface) {
                $csrfInterface = $builderOptions["csrf"];
            } else {
                $eMessage = "Builder's csrf option must be an instance of UForm\Validator\Csrf\CsrfInterface";
                throw new BuilderException($eMessage);
            }
        } else {
            $csrfInterface = Environment::getCsrfResolver();
        }
        if ($csrfInterface) {
            $csrf = new Element\Primary\Input\Hidden("__uf_csrf", $csrfInterface->getToken());
            $csrf->addValidator(new Validator\Csrf($csrfInterface));
        }
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
