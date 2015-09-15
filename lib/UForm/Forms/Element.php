<?php
/**
 * Element
*/
namespace UForm\Forms;

use UForm\Filter;
use UForm\Forms\Exception,
        UForm\Forms\Form,
        UForm\Validation\ChainedValidation,
        UForm\Tag,
        UForm\Validation
        ;



/**
 * This is a base class for form elements
 *
 *
 *
 * @semanticType element
 */
abstract class Element
{
    /**
     * Form
     *
     * @var null|\UForm\Forms\Form
     * @access protected
    */
    protected $_parent;

    protected $_prename;
    protected $_name;
    protected $_internalPrename;
    protected $_internalName;
    
    protected $_attributes;
    protected $_options;

    /**
     * Validators
     *
     * @var Validation\Validator[]
     * @access protected
    */
    protected $_validators;

    /**
     * Filters
     *
     * @var \UForm\Filter[]
    */
    protected $_filters = array();
    
    
    /**
     *
     * @var Form
     */
    protected $_form;


    /**
     * list of type the elements belong
     * for instance a TabGroup is a "tabGroup", a "group" and an "elementContainer"
     * it's useful for custom rendering when used with "isType()"
     * @var array
     */
    protected $semanticTypes = [];


    /**
     * \UForm\Forms\Element constructor
     *
     * @param string $name
     * @param array|null $attributes
     * @throws Exception
     */
    public function __construct($name = null, $attributes = null, $validators = null, $filters = null)
    {
        $this->_name = $name;

        if(is_array($attributes) === true) {
            $this->_attributes = $attributes;
        }

        if(null !== $validators){
            $this->addValidators($validators);
        }

        if(null !== $filters){
            foreach ($filters as $f) {
                $this->addFilter($f);
            }
        }

        $this->addSemanticType("element");

    }

    /**
     * add a semantic type that can check with isType()
     * order of semantic type is very important because it's used for form rendering
     * @param $type string the semantic type to add
     * @return $this
     */
    public function addSemanticType($type){
        array_unshift($this->semanticTypes, $type);
        return $this;
    }

    /**
     * check if the element has the specified type.
     * types are set with addSemanticType()
     * @param $type string the semantic type to check for existence
     * @return bool
     */
    public function isType($type){
        return in_array($type, $this->semanticTypes);
    }

    public function getSemanticTypes(){
        return $this->semanticTypes;
    }

    public function addClass($className){

        $currentClass = $this->getAttribute("class");

        if($currentClass){
            $currentClass .= " ";
        }

        $currentClass .= $className;

        $this->setAttribute("class", $className);

    }

    /////////
    //
    // PARENT
    //
    
    /**
     * Internal use only sets the parent
     * @param \UForm\Forms\Form $p
     * @return $this
     * @throws Exception
     */
    public function setParent(ElementContainer $p,$iname = null){
        $this->_form = $p->getForm();
        $this->_parent = $p;
        $this->_internalPrename = $p->getInternalName(true);
        $this->_prename = $p->getName(true, true);
        if ($iname) {
            $this->_internalName = $iname;
        }
        return $this;
    }

    public function getForm() {
        return $this->_form;
    }

        
    /**
     * Get the parent Element
     * @return ElementContainer
     */
    public function getParent() {
        return $this->_parent;
    }

    
    
    
    
    /////////////
    //
    // NAME / INAME
    //
    
    /**
     * Returns the element's name
     *
     * @return string
     */
    public function getName($prenamed = false , $dottedNotation = false){
        if ($prenamed && !empty($prenamed) && $this->_prename && !empty($this->_prename)) {
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
    
    public function getInternalName($prenamed = false) {
        if ($prenamed && !empty($prenamed) && $this->_internalPrename && !empty($this->_internalPrename)) {
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
     * @return \UForm\Forms\Element
     * @throws Exception
     */
    public function setFilters($filters)
    {
            if(is_string($filters) === false ||
                    is_array($filters) === false) {
                    throw new Exception('Invalid parameter type.');
            }

            $this->_filters = $filters;

            return $this;
    }

    /**
     * Adds a filter to current list of filters
     *
     * @param callable|Filter $filter
     * @throws Exception
     */
    public function addFilter($filter){
        if(is_callable($filter)){
            $filter = new \UForm\DirectFilter($filter);
        }

        $this->_filters[] = $filter;
    }

    /**
     * Returns the element's filters
     *
     * @return null|string|array
     */
    public function getFilters()
    {
            return $this->_filters;
    }
    
    
    
    
    
    
    /////////////////
    //
    // VALIDATORS
    //

    /**
     * Adds a group of validators
     *
     * @param \UForm\Validation\ValidatorInterface[] $validators
     * @param boolean|null $merge
     * @return $this
     * @throws Exception
     */
    public function addValidators($validators, $merge = true)
    {

        if(is_array($validators) === false) {
            throw new Exception("The validators parameter must be an array");
        }

        if(is_array($this->_validators) === false) {
            $this->_validators = array();
        }

        //@note nothing happens when $merge === false
        if($merge === true) {
            if(is_array($this->_validators) === true) {
                $this->_validators = array_merge($this->_validators, $validators);
            } else {
                $this->_validators = $validators;
            }
        }

        return $this;
    }

    /**
     * Adds a validator to the element
     *
     * @param \UForm\Validation\Validator $validator
     * @throws Exception
     */
    public function addValidator(Validation\Validator $validator)
    {

        if(is_callable($validator)){
            $validator = new Validation\DirectValidator($validator);
        }else if(is_object($validator) === false ||
            $validator instanceof Validation\Validator === false) {
            throw new Exception('The validators parameter must be an object extending UForm\Validation\Validator ');
        }else if(is_array($this->_validators) === false) {
            $this->_validators = array();
        }

        $this->_validators[] = $validator;
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

    
    
    
    /**

    /**
     * Sets a default attribute for the element
     *
     * @param string $attribute
     * @param mixed $value
     * @return Element
     * @throws Exception
     */
    public function setAttribute($attribute, $value){
            if(is_string($attribute) === false) {
                    throw new Exception('Invalid parameter type.');
            }

            if(is_array($this->_attributes) === false) {
                    $this->_attributes = array();
            }

            $this->_attributes[$attribute] = $value;

            return $this;
    }

    /**
     * Returns the value of an attribute if present
     *
     * @param string $attribute
     * @param mixed $defaultValue
     * @return mixed
     * @throws Exception
     */
    public function getAttribute($attribute, $defaultValue = null){
            if(is_string($attribute) === false) {
                    throw new Exception('Invalid parameter type.');
            }

            if(is_array($this->_attributes) === true &&
                    isset($this->_attributes[$attribute]) === true) {
                    return $this->_attributes[$attribute];
            }

            return $defaultValue;
    }

    /**
     * Sets default attributes for the element
     *
     * @param array $attributes
     * @return \UForm\Forms\Element
     * @throws Exception
     */
    public function setAttributes($attributes){
            if(is_array($attributes) === false) {
                    throw new Exception("Parameter 'attributes' must be an array");
            }

            $this->_attributes = $attributes;

            return $this;
    }

    /**
     * Returns the default attributes for the element
     *
     * @return array
     */
    public function getAttributes(){
        if(is_array($this->_attributes) === false) {
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
     * @param string $option
     * @param mixed $value
     * @return \UForm\Forms\ElementInterface
     * @throws Exception
     */
    public function setUserOption($option, $value){
        if(is_string($option) === false) {
            throw new Exception('Invalid parameter type.');
        }
        if(is_array($this->_options) === false) {
            $this->_options = array();
        }
        $this->_options[$option] = $value;
        return $this;
    }

    /**
     * Returns the value of an option if present
     *
     * @param string $option
     * @param mixed $defaultValue
     * @return mixed
     * @throws Exception
     */
    public function getUserOption($option, $defaultValue = null){
        if(is_array($this->_options) === true &&
            isset($this->_options[$option]) === true) {
            return $this->_options[$option];
        }
        return $defaultValue;
    }

    /**
     * Sets options for the element
     *
     * @param array $options
     * @return \UForm\Forms\ElementInterface
     * @throws Exception
     */
    public function setUserOptions($options){
        if(is_array($options) === false) {
            throw new Exception("Parameter 'options' must be an array");
        }
        $this->_options = $options;
        return $this;
    }

    /**
     * Returns the options for the element
     *
     * @return array|null
     */
    public function getUserOptions()
    {
            return $this->_options;
    }

    public function setName($_name) {
        $this->_name = $_name;
    }

    
    public function isValid(ChainedValidation $cV){
        return $cV->getValidation($this->getInternalName(true) , true);
    }
    
    public function childrenAreValid(ChainedValidation $cV){
        return $this->isValid($cV);
    }

    public function prepareValidation($localValues,  ChainedValidation $cV){
        $validators = $this->getValidators();
        $filters    = $this->getFilters();
        
        $v = new \UForm\Validation($this, $localValues , $cV, $validators);
        $v->setFilters($filters);
        
        $cV->addValidation($v);
    }

    
    
    
    
    
    
    
    
    
    /////////////////////////:
    //
    // ADDITIONAL LOGIC
    //
    
    public function addRequiredValidator($message){
        $validator = new Validation\Validator\Required(array("message"=>$message));
        $this->addValidator($validator);
    }
    
    
    
}
