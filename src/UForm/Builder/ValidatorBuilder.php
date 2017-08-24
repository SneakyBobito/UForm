<?php
/**
 * @license see LICENSE
 */

namespace UForm\Builder;

use UForm\Builder;
use UForm\Form\Element;
use UForm\Validator;
use UForm\Validator\Required;
use UForm\Validator\StringLength;

trait ValidatorBuilder
{

    /**
     * @see FluentElement::last()
     * @return Element
     */
    public abstract function last();

    /**
     * Adds a required validator
     * @see Required
     * @return $this
     */
    public function required()
    {
        $this->last()->addValidator(new Required());
        $this->last()->setOption('required', true);
        return $this;
    }


    /**
     * Adds a StringLength validator
     * @see StringLength
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
     * Add a inRange validator to the latest element
     *
     * @see InRange
     * @param array $values
     * @return $this
     */
    public function inRange(array $values)
    {
        $this->last()->addValidator(new Validator\InRange($values));
        return $this;
    }

    /**
     * Adds the given validator to the last element
     * @param callable|Validator $validator
     * @return $this
     * @throws \Exception
     */
    public function validator($validator)
    {
        $this->last()->addValidator($validator);
        return $this;
    }

    /**
     * Adds an alphanum validator to the last element
     * @see AlphaNum
     * @param bool|false $allowSpace
     * @return $this
     */
    public function alphaNum($allowSpace = false)
    {
        $this->last()->addValidator(new Validator\AlphaNum($allowSpace));
        return $this;
    }

    /**
     * Adds a regexp validator to the last element
     * @see Validator\Regexp
     * @param bool|false $allowSpace
     * @return $this
     */
    public function regexp($pattern, $message = null, $format = null)
    {
        $this->last()->addValidator(new Validator\Regexp($pattern, $message, $format));
        return $this;
    }
}
