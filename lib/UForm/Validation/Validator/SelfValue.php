<?php
/**
 * Created by PhpStorm.
 * User: sghzal
 * Date: 9/8/15
 * Time: 2:52 PM
 */

namespace UForm\Validation\Validator;


use UForm\Validation;
use UForm\Validation\Validator;

/**
 * Class SelfValue
 *
 * the element being validated must implement RangeValueValidationInterface
 *
 * @see \UForm\Validation\Element\RangeValueValidationInterface
 *
 * @package UForm\Validation\Validator
 */
class SelfValue extends Validator{

    protected $validationValues;


    public function __construct($options = [])
    {
        parent::__construct($options);
    }


    /**
     * @inheritdoc
     */
    public function validate(Validation $validator)
    {

        $element = $validator->getElement();

        if(!$element instanceof Validation\Element\RangeValueValidationInterface){
            throw new \Exception("Cant validate an element that does not implement RangeValueValidationInterface");
        }

        $values = $element->getValueRange();


        if(!in_array($validator->getValue(), $values)){

            $message = $this->getOption("message");
            if(!$message){
                $message = "Value not valid";
            }

            $validator->appendMessage($message);
            return false;
        }

        return true;
    }
}