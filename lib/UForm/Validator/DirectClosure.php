<?php

namespace UForm\Validator;

use UForm\Validator;

class DirectClosure extends Validator
{
    
    protected $closure;


    public function __construct(callable $closure , $options = null) {
        $this->closure = $closure;
        parent::__construct($options);
    }

    /**
     * Executes the validation
     *
     * @param \UForm\Validation $validator
     */
   public function validate(\UForm\Validation $validator)
   {
       $closure = $this->closure;
       return $closure($validator,$this);
   }
}