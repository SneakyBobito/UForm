<?php
/**
 * Validation
 *
 * @author Andres Gutierrez <andres@phalconphp.com>
 * @author Eduar Carvajal <eduar@phalconphp.com>
 * @author Wenzel Pünter <wenzel@phelix.me>
 * @version 1.2.6
 * @package Phalcon
*/
namespace UForm;

use UForm\Form\Element;
use UForm\Form\FormContext;
use UForm\Validation\ChainedValidation;
use UForm\Validation\Exception;
use Uform\Validation\Message;
use UForm\Validation\Message\Group;

/**
 * That an object that helps to achieve one and only one validation schema through validators
 * It wraps that validated element and the currently validated form context. Validators can add messages that will serve
 * for error outputting
 */
class ValidationItem {

    use ValidatorGroup;

	/**
	 * The local value being validated
	 * 
	 * @var DataContext
	*/
	protected $dataLocal = null;

    /**
     *
     * the element being validated
     *
     * @var Form\Element
     */
    protected $element;

	/**
	 * Messages added by the validators
	 * 
	 * @var null|\UForm\Validation\Message\Group
	 */
	protected $_messages = null;
    protected $_valid = false;

    protected $formContext;


    /**
     * @param Element $elements
     * @param array $localData
     * @param ChainedValidation $cV
     */
    public function __construct(DataContext $data, Element $elements, FormContext $formContext)
    {
        $this->formContext = $formContext;
        $this->element = $elements;
        $this->dataLocal = $data;
    }


    /**
     * Get the local data set.
     * Be aware that it's not the value for the current element. If you want the value for the current element
     * use getValue() instead
     * @return DataContext the local data
     */
    public function getLocalData() {
        return $this->dataLocal;
    }

    /**
     * The local name, it matches the name of the data in the local data
     * @return mixed|null|string
     */
    public function getLocalName() {
        return $this->element->getName();
    }

    /**
     * The element being validated
     * @return Element
     */
    public function getElement() {
        return $this->element;
    }

    /**
     * The chainedValidation it belongs to
     * @return ChainedValidation
     */
    public function getChainedValidation() {
        return $this->formContext->getChainedValidation();
    }

    /**
     * reset validation to its initial state
     */
    public function resetValidation(){
        $this->_valid = true;
        $this->_messages = new Group();
    }
        
    /**
     * Validate a set of data according to a set of rules
     *
     * @return boolean
     * @throws Exception
     */
    public function validate(){
        $validators = $this->element->getValidators();

        foreach($validators as $v) {
            if (false === $v->validate($this)) {
                $this->_valid = false;
            }
        }
        return $this->_valid;
    }

    public function isValid(){
        return $this->_valid == true;
    }

    /**
     * Returns the registered validators
     *
     * @return \UForm\Validation\Message\Group
     */
    public function getMessages()
    {
        return $this->_messages;
    }

    /**
     * Appends a message to the messages list
     *
     * @param string $message
     */
    public function appendMessage(Message $message, $elementName = null){
        if(null == $elementName){
            $this->_messages->appendMessage($message);
        }else{
            $v = $this->getChainedValidation()->getValidation($elementName);
            if(!$v){
                throw new \Uform\Exception('Unable to append message : element with ID='.$elementName.' is not part of the form.');
            }
            $v->appendMessage($message);
        }
    }


    /**
     * Gets the value of the current element
     * @return mixed value of the current element
     */
    public function getValue()
    {
        return $this
            ->dataLocal
            ->getDirectValue(
                $this->getLocalName()
            );
    }

    /**
     * Find a value for an element
     * @param $name
     * @return
     */
    public function getValueFor($name)
    {
        return $this
            ->formContext
            ->getChainedValidation()
            ->getValidation($name)
            ->getValue();
    }

}