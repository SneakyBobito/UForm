<?php
/**
 * @license see LICENSE
 */

namespace UForm\Builder;

use UForm\Form\Element;
use UForm\Validator;
use UForm\Validator\Required;

trait ValidatorBuilder
{

    /**
     * @return Element
     */
    public abstract function last();

    /**
     * Add a required validator
     * @return $this
     */
    public function required()
    {
        $this->last()->addValidator(new Required());
        $this->last()->setOption("required", true);
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
