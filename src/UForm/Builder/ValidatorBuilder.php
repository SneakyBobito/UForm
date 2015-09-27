<?php
/**
 * @license see LICENSE
 */

namespace UForm\Builder;

use UForm\Form\Element;
use UForm\Validator;
use UForm\Validator\Required;
use UForm\Validator\StringLength;

trait ValidatorBuilder
{

    /**
     * @return Element
     */
    public abstract function last();

    /**
     * Adds a required validator
     * @see UForm\Validator\Required
     * @return $this
     */
    public function required()
    {
        $this->last()->addValidator(new Required());
        $this->last()->setOption("required", true);
        return $this;
    }


    /**
     * Adds a StringLength validator
     * @see UForm\Validator\StringLength
     * @param int $min the minimum length of the string
     * @param int $max the maximum length of the string
     * @return $this
     */
    public function stringLength($min, $max)
    {
        $this->last()->addValidator(new StringLength($min, $max));
        return  $this;
    }

    /**
     * @param callable|Validator $validator
     * @return $this
     * @throws \Exception
     */
    public function validator($validator)
    {
        $this->last()->addValidator($validator);
        return $this;
    }
}
