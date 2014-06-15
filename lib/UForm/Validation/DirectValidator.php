<?php

namespace UForm\Validation;

use \UForm\Validation\Validator;

class DirectValidator extends Validator
{
    
    protected $closure;


    public function __construct( $closure , $options = null) {
        
        if(!is_callable($closure))
            throw new Exception ("Param 1 must be a closure");
        
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