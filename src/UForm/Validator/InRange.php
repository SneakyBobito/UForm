<?php
/**
 * @license see LICENSE
 */

namespace UForm\Validator;

use UForm\Form\Element\ValueRangeInterface;
use UForm\InvalidArgumentException;
use UForm\Validation\Message;
use UForm\Validation\ValidationItem;
use UForm\Validator;

/**
 * Check if the value for the validated element are in the given range
 * Range can be either an array of values or an intstance of ValueRangeInterface
 *
 * @see UForm\Form\Element\ValueRangeInterface
 */
class InRange extends Validator{

    const NOT_IN_RANGE = "InRange::NOT_IN_RANGE";

    protected $range;

    public function __construct($range)
    {

        if(!is_array($range) && !($range instanceof ValueRangeInterface)){
            throw new InvalidArgumentException("range", "array or instance of ValueRangeInterface", $range);
        }

        $this->range = $range;
    }


    /**
     * @inheritdoc
     */
    public function validate(ValidationItem $validationItem)
    {

        $hasMatch = false;

        if(is_array($this->range)){
            foreach($this->range as $value){
                if($value == $validationItem->getValue()){
                    $hasMatch = true;
                    break;
                }
            }
        }else{
            if($this->range->valueIsInRange($validationItem->getLocalData()->getDataCopy())){
                $hasMatch = true;
            }
        }

        if(!$hasMatch){
            $validationItem->setInvalid();
            $value = $validationItem->getValue();
            $message = new Message("Value not valid", ["value" => $value], self::NOT_IN_RANGE);
            $validationItem->appendMessage($message);
        }


    }


}
