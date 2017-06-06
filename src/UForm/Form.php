<?php

namespace UForm;

use UForm\DataBind\ArrayBinder;
use UForm\DataBind\ObjectBinder;
use UForm\Filtering\FilterChain;
use UForm\Form\Element\Container\Group as ElementGroup;
use UForm\Form\FormContext;
use UForm\Validation;

/**
 * UForm\Form\Form
 *
 * This component allows to build forms using an object-oriented interface
 * @semanticType form
 */
class Form extends ElementGroup
{

    const METHOD_POST = 'POST';
    const METHOD_GET = 'GET';
    const ENCTYPE_MULTIPART_FORMDATA = 'multipart/form-data';

    protected $action;
    protected $method;
    protected $enctype;

    /**
     * @param string $action form action
     * @param string $method form method
     */
    public function __construct($action = null, $method = null)
    {
        $this->form = $this;
        parent::__construct();
        $this->addSemanticType('form');

        if ($action) {
            $this->setAction($action);
        }
        if ($method) {
            $this->setMethod($method);
        } else {
            $this->setMethod(self::METHOD_POST);
        }
    }



    public function getAction()
    {
        return $this->action;
    }

    public function setAction($action)
    {
        $this->action = $action;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return mixed
     */
    public function getEnctype()
    {
        return $this->enctype;
    }

    /**
     * @param mixed $enctype
     */
    public function setEnctype($enctype)
    {
        $this->enctype = $enctype;
    }




    /**
     * validates the form using the data given in parameter
     * @var array|null $data the data used for the validation.
     * @return FormContext
     */
    public function validate($inputData, $isSubmitted = true)
    {
        $formContext = $this->generateContext($inputData, $isSubmitted);
        $formContext->validate();
        return $formContext;
    }

    /**
     * Binds data to the entity.
     * It does not apply the filter if you want to apply form filters please use $formContext->bind
     * or sanitize the data before
     *
     * @see sanitizeData();
     * @see FormContext::bind();
     *
     * @param object|array $entity
     * @param array $data
     * @param array|null $whitelist
     * @return \UForm\Form
     * @throws Exception
     */
    public function bind(&$entity, array $data, $whitelist = null)
    {
        if (is_object($entity)) {
            $binder = new ObjectBinder($entity);
        } elseif (is_array($entity)) {
            $binder = new ArrayBinder($entity);
        } else {
            throw new InvalidArgumentException('$entity', 'object or array', $entity);
        }

        $blackList = [];

        foreach ($data as $key => $value) {
            $element = $this->getElement($key);
            if (!$element) {
                $blackList[] = $key;
            }
        }
        $binder->setBlacklist($blackList);
        $binder->setWhitelist($whitelist);

        $binder->bind($data);
    }

    /**
     * Generate a form context with the given data
     * @param null $data
     * @return FormContext
     */
    public function generateContext($data = null, $isSubmitted = false)
    {
        if (null === $data) {
            $data = null;
        }

        $filterChain = new FilterChain($this);
        $this->prepareFilterChain($filterChain);

        $saneData = $filterChain->sanitizeData($data, $isSubmitted);

        $formContext = new FormContext($this, $isSubmitted, new DataContext($saneData), new DataContext($data));
        return $formContext;
    }

    /**
     * Get input data from global variables ($_POST $_GET $_FILE...)
     */
    public function getInputFromGlobals()
    {

        switch ($this->getMethod()) {
            case 'POST':
                $finalData = $_POST + FileUpload::fromGlobalFilesVariable($_FILES, true);
                break;

            case 'GET':
                $finalData = $_GET;
                break;

            // TODO other methods

            default:
                $finalData = [];
                break;
        }

        return $finalData;
    }
}
