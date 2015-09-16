<?php
/**
 * Element
 */
namespace UForm\Form;

use UForm\DirectFilter;
use UForm\Filter;
use UForm\Form;
use UForm\Form\Element\Container;
use UForm\SemanticItem;
use UForm\Validation;
use UForm\Validation\ChainedValidation;


/**
 * This is a base class for form elements
 *
 * @semanticType element
 */
abstract class Element
{
    use SemanticItem;

    /**
     * @var \UForm\Form\Element\Container
     */
    protected $_parent;

    protected $_prename;
    protected $_name;

    protected $_internalPrename;
    protected $_internalName;

    protected $_attributes = [];
    protected $_options = [];

    /**
     * Validators
     *
     * @var Validation\Validator[]
     * @access protected
     */
    protected $_validators = [];

    /**
     * Filters
     *
     * @var \UForm\Filter[]
     */
    protected $_filters = [];


    /**
     *
     * @var Form
     */
    protected $_form;

    /**
     * \UForm\Form\Element constructor
     *
     * @param string $name
     * @param array|null $attributes
     * @throws Exception
     */
    public function __construct($name = null, $attributes = null, $validators = null, $filters = null)
    {
        $this->_name = $name;

        if (is_array($attributes) === true) {
            $this->_attributes = $attributes;
        }

        if (null !== $validators) {
            $this->addValidators($validators);
        }

        if (null !== $filters) {
            foreach ($filters as $f) {
                $this->addFilter($f);
            }
        }

        $this->addSemanticType("element");
    }


    public function addClass($className)
    {

        $currentClass = $this->getAttribute("class");

        if ($currentClass) {
            $currentClass .= " ";
        }

        $currentClass .= $className;

        $this->setAttribute("class", $currentClass);

    }

    /////////
    //
    // PARENT
    //

    /**
     * Internal use only. Set a pointer to the parent element
     * @param Form\Element\Container $parent
     * @return $this
     * @throws Exception
     */
    public function setParent(Container $parent)
    {
        $this->_form = $parent->getForm();
        $this->_parent = $parent;
        $this->refreshParent();
        return $this;
    }

    /**
     * Should be called when a change occurs on the parents and the info related to the parent need to be updated
     */
    public function refreshParent(){
        if($this->_parent) {
            $this->setNamespace($this->_parent->getName(true, true));
            $this->setInternalNamespace($this->_parent->getInternalName(true));
        }
    }

    /**
     * Internal use only. Set the namespace (parent dependant)
     * @param $namespace
     */
    public function setNamespace($namespace){
        $this->_prename = $namespace;
    }

    /**
     * Internal use only. Set the internal namespace (parent dependant)
     * @param $namespace
     */
    public function setInternalNamespace($namespace){
        $this->_internalPrename = $namespace;
    }

    /**
     * Internal use only. Set the internal name (parent dependant)
     * @param $name
     */
    public function setInternalName($name){
        $this->_internalName = $name;
    }

    /**
     * Get the form the element belongs to
     * @return Form the form the element belongs to
     */
    public function getForm()
    {
        return $this->_form;
    }


    /**
     * Get the parent Element
     * @return Container the container that contains the element
     */
    public function getParent()
    {
        return $this->_parent;
    }





    /////////////
    //
    // NAME / INAME
    //

    /**
     * Change the name of the element
     * @param $name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * @param bool $namespaced if set to true it will return the name of the element with its namespace. The namespace it the name of all the parent elements
     * @param bool $dottedNotation if set to true will return the nameme in a dotted notation, else it will use the html valid array notation
     * @return mixed|null|string
     */
    public function getName($namespaced = false, $dottedNotation = false)
    {
        if ($namespaced && !empty($namespaced) && $this->_prename && !empty($this->_prename)) {
            if ($dottedNotation) {
                return $this->_prename . "." . $this->_name;
            } else {
                $ppart = explode(".", $this->_prename);
                $ppart[] = $this->_name;
                $final = array_shift($ppart);
                $final .= "[" . implode("][", $ppart) . "]";
                return $final;
            }
        } else {
            return $this->_name;
        }
    }

    public function getInternalName($namespaced = false)
    {
        if ($namespaced && !empty($namespaced) && $this->_internalPrename && !empty($this->_internalPrename)) {
            return $this->_internalPrename . "." . $this->_internalName;
        } else {
            return $this->_internalName;
        }
    }








    /////////////
    //
    // FILTER
    //

    /**
     * Sets the element's filters
     *
     * @param array|string $filters
     * @return $this
     * @throws Exception
     */
    public function setFilters($filters)
    {
        if (is_string($filters) === false ||
            is_array($filters) === false
        ) {
            throw new Exception('Invalid parameter type.');
        }

        $this->_filters = $filters;

        return $this;
    }

    /**
     * Adds a filter to current list of filters
     *
     * @param callable|Filter $filter the filter to add. It can also be a callback function that will be transformed in a @see DirectFilter
     * @throws Exception
     * @return $this;
     */
    public function addFilter($filter)
    {
        if (is_callable($filter)) {
            $filter = new DirectFilter($filter);
        }
        $this->_filters[] = $filter;
        return $this;
    }

    /**
     * Returns the element's filters
     * @return Filter[] the filters of the element
     */
    public function getFilters()
    {
        return $this->_filters;
    }

    /**
     * Apply filters of the element to sanitize the given data
     * @param mixed $data the data to sanitize
     * @return mixed the sanitized data
     */
    public function sanitizeData($data)
    {
        $filters = $this->getFilters();
        foreach ($filters as $filter) {
            $data = $filter->filter($data);
        }
        return $data;
    }




    /////////////////
    //
    // VALIDATORS
    //

    /**
     * Adds a group of validators
     *
     * @param \UForm\Validation\Validator[] $validators
     * @return $this
     * @throws Exception
     */
    public function addValidators($validators)
    {
        if (is_array($validators) === false) {
            throw new Exception("The validators parameter must be an array");
        }
        foreach ($validators as $validator) {
            $this->addValidator($validator);
        }
        return $this;
    }

    /**
     * Adds a validator to the element
     *
     * @param \UForm\Validation\Validator|callable $validator the validator to add, it can also be a callback that will be transformed in a @see DirectValidator
     * @throws Exception
     * @return $this
     */
    public function addValidator($validator)
    {
        if (is_callable($validator)) {
            $validator = new Validation\DirectValidator($validator);
        } else if (is_object($validator) === false ||
            $validator instanceof Validation\Validator === false
        ) {
            throw new Exception('The validators parameter must be an object extending UForm\Validation\Validator ');
        }
        $this->_validators[] = $validator;
        return $this;
    }

    /**
     * Returns the validators registered for the element
     *
     * @return \UForm\Validation\Validator[]
     */
    public function getValidators()
    {
        return $this->_validators ? $this->_validators : array();
    }




    //////////////
    // ATTRIBUTES
    //

    /**
     * Sets a value for an attribute. Will replace the current one if it already exists
     *
     * @param string $attribute name of the attribute
     * @param string $value value of the attribute
     * @return $this
     * @throws Exception
     */
    public function setAttribute($attribute, $value)
    {
        if (is_string($attribute) === false) {
            throw new Exception('Invalid parameter type.');
        }

        $this->_attributes[$attribute] = $value;

        return $this;
    }

    /**
     * Returns the value of an attribute if present
     *
     * You can specify a default value to return if the attribute does not exist
     *
     * @param string $attribute name of the attribute
     * @param mixed $defaultValue value to return if the attribute does not exist
     * @return string the value of the attribute
     * @throws Exception
     */
    public function getAttribute($attribute, $defaultValue = null)
    {
        if (is_string($attribute) === false) {
            throw new Exception('Invalid parameter type.');
        }
        if (isset($this->_attributes[$attribute])) {
            return $this->_attributes[$attribute];
        }
        return $defaultValue;
    }

    /**
     * Sets values for many attributes
     *
     * @param array $attributes list of attributes to add ["name" => "value"]
     * @return $this
     * @throws Exception
     */
    public function addAttributes($attributes)
    {
        if (is_array($attributes) === false) {
            throw new Exception("Parameter 'attributes' must be an array");
        }
        foreach ($attributes as $attribute => $value) {
            $this->addAttributes($attribute, $value);
        }
        return $this;
    }

    /**
     * Returns the attributes for the element
     * @return array attributes of the element
     */
    public function getAttributes()
    {
        if (is_array($this->_attributes) === false) {
            return array();
        }
        return $this->_attributes;
    }

    ///////////
    //
    // OPTION
    //

    /**
     * Sets an option for the element
     *
     * @param string $option name of the option
     * @param mixed $value value of the option
     * @return $this
     * @throws Exception
     */
    public function setUserOption($option, $value)
    {
        if (is_string($option) === false) {
            throw new Exception('Invalid parameter type.');
        }
        $this->_options[$option] = $value;
        return $this;
    }

    /**
     * Returns the value of an option if present
     *
     * You can specify a default value to return if the option does not exist
     *
     * @param string $option name of the option
     * @param mixed $defaultValue default value to return if option does not exist
     * @return mixed value of the option or the default value
     * @throws Exception
     */
    public function getUserOption($option, $defaultValue = null)
    {
        if (is_array($this->_options) === true &&
            isset($this->_options[$option]) === true
        ) {
            return $this->_options[$option];
        }
        return $defaultValue;
    }

    /**
     * Set value of many options
     *
     * @param array $options list of the options ["optionName" => "value"]
     * @return $this
     * @throws Exception
     */
    public function setUserOptions($options)
    {
        if (is_array($options) === false) {
            throw new Exception("Parameter 'options' must be an array");
        }
        foreach ($options as $option => $value) {
            $this->setUserOption($option, $value);
        }
        return $this;
    }

    /**
     * Returns the options for the element
     *
     * @return array
     */
    public function getUserOptions()
    {
        return $this->_options;
    }


    /**
     * Internal use - prepare the validation object
     *
     * Intended to be overwritten
     *
     * @param $localValues
     * @param ChainedValidation $cV
     */
    public function prepareValidation($localValues, ChainedValidation $cV)
    {
        $validators = $this->getValidators();
        $filters = $this->getFilters();

        $v = new \UForm\Validation($this, $localValues, $cV, $validators);
        $v->setFilters($filters);

        $cV->addValidation($v);
    }
}
