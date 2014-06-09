<?php

namespace UForm\Validation;

use \UForm\Validation\Validator,
	\UForm\Validation\ValidatorInterface,
	\UForm\Validation\Exception,
	\UForm\Validation\Message,
	\UForm\Validation;

/**
 * Phalcon\Validation\Validator\Confirmation
 *
 * Checks that two values have the same value
 *
 *<code>
 *use Phalcon\Validation\Validator\Confirmation;
 *
 *$validator->add('password', new Confirmation(array(
 *   'message' => 'Password doesn\'t match confirmation',
 *   'with' => 'confirmPassword'
 *)));
 *</code>
 * 
 * @see https://github.com/phalcon/cphalcon/blob/1.2.6/ext/validation/validator/confirmation.c
 */
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
	 * @param string $attribute
	 * @return boolean
	 * @throws Exception
	 */
	public function validate($validator)
	{
            $closure = $this->closure;
            return $closure($validator,$this);
	}
}