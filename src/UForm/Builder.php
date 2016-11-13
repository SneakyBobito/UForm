<?php

namespace UForm;

use UForm\Builder\BuilderException;
use UForm\Builder\FilterBuilder;
use UForm\Builder\FluentElement;
use UForm\Builder\GroupBuilder;
use UForm\Builder\InputBuilder;
use UForm\Builder\ValidatorBuilder;
use UForm\Form\Element;
use UForm\Form\Element\Primary\Input\Hidden;
use UForm\Validator;
use UForm\Validator\Csrf;
use UForm\Validator\ValidatorProxy;

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

        $this->processCsrf($builderOptions);
    }

    /**
     * Builds the csrf token
     * @param $builderOptions
     * @throws BuilderException
     */
    private function processCsrf($builderOptions)
    {

        // Check if csrf interface was set in the option
        if (isset($builderOptions['csrf']) && $builderOptions['csrf']) {
            if ($builderOptions['csrf'] instanceof Validator\Csrf\CsrfInterface) {
                $csrfInterface = $builderOptions['csrf'];
            } else {
                $eMessage = "Builder's csrf option must be an instance of UForm\Validator\Csrf\CsrfInterface";
                throw new BuilderException($eMessage);
            }
        // Or else check from environment
        } else {
            $csrfInterface = Environment::getCsrfResolver();
        }


        if ($csrfInterface) {
            if (isset($builderOptions['csrf-name'])) {
                $csrfName = $builderOptions['csrf-name'];
            } else {
                $csrfName = '__uf_csrf';
            }

            $csrf = new Hidden($csrfName);
            $csrfValidator = new Csrf($csrfInterface);
            $csrf->addValidator(new ValidatorProxy($this->form, $csrfValidator));
            $this->form->addElement($csrf);
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
     * @return static
     */
    public static function init($action = null, $method = null, $builderOptions = [])
    {
        return new static($action, $method, $builderOptions);
    }
}
