<?php
/**
 * @license see LICENSE
 */

namespace UForm;

use UForm\Validator\DirectClosure;

trait ValidatorGroup
{

    /**
     * @var \UForm\Validator[]
     */
    protected $validatorGroup = [];

    /**
     * Adds a group of validators
     *
     * @param \UForm\\UForm\Validator[] $validators
     * @return Validator[]
     * @throws Exception
     */
    public function addValidators(array $validators)
    {
        $created = [];
        foreach ($validators as $validator) {
            $created[] = $this->addValidator($validator);
        }
        return $created;
    }

    /**
     * Adds a validator
     *
     * @param \UForm\\UForm\Validator|callable $validator the validator to add, it can also be a callback that
     * will be transformed in a @see DirectValidator
     * @throws Exception
     * @return Validator the validator that was added
     */
    public function addValidator($validator)
    {
        if (is_callable($validator)) {
            $validator = new DirectClosure($validator);
        } elseif (!is_object($validator) || !$validator instanceof \UForm\Validator) {
            throw new InvalidArgumentException('validator', 'instance of UForm\\UForm\Validator', $validator);
        }
        $this->validatorGroup[] = $validator;
        return $validator;
    }

    /**
     * Returns the validators registered for the element
     *
     * @return Validator[]
     */
    public function getValidators()
    {
        return $this->validatorGroup;
    }

    /**
     * Resets the validators and set the given validators instead
     *
     * @param array|null $validators array of the new validators to set.
     * Can be null or an empty array to reset remove all validators
     * @return Validator[] the validator that were added to the group
     * @throws Exception
     */
    public function setValidators($validators)
    {
        $this->validatorGroup = [];

        if (null !== $validators) {
            return $this->addValidators($validators);
        } else {
            return [];
        }
    }
}
