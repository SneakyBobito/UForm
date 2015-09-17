<?php
/**
 * @license see LICENSE
 */

namespace UForm;


trait ValidatorGroup {

    /**
     * @var Validation\Validator[]
     */
    protected $_validatorGroup = [];

    /**
     * Adds a group of validators
     *
     * @param \UForm\Validation\Validator[] $validators
     * @return $this
     * @throws Exception
     */
    public function addValidators($validators)
    {
        if (!is_array($validators)) {
            throw new Exception("The validators parameter must be an array");
        }
        foreach ($validators as $validator) {
            $this->addValidator($validator);
        }
        return $this;
    }

    /**
     * Adds a validator
     *
     * @param \UForm\Validation\Validator|callable $validator the validator to add, it can also be a callback that will be transformed in a @see DirectValidator
     * @throws Exception
     * @return $this
     */
    public function addValidator($validator)
    {
        if (is_callable($validator)) {
            $validator = new Validation\DirectValidator($validator);
        } else if (!is_object($validator) || !$validator instanceof Validation\Validator) {
            throw new Exception('The validators parameter must be an object extending UForm\Validation\Validator ');
        }
        $this->_validatorGroup[] = $validator;
        return $this;
    }

    /**
     * Returns the validators registered for the element
     *
     * @return \UForm\Validation\Validator[]
     */
    public function getValidators()
    {
        return $this->_validatorGroup;
    }

    /**
     * Resets the validators and set the given validators instead
     *
     * @param array|null $validators array of the new validators to set. Can be null or an empty array to reset remove all validators
     * @return $this
     * @throws Exception
     */
    public function setValidators($validators)
    {
        $this->_validatorGroup = [];

        if(null !== $validators) {
            return $this->addValidators($validators);
        }else{
            return $this;
        }
    }

    public function validateData(){

    }

}