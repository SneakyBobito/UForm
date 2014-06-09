<?php
/**
 * Confirmation Validator
 *
 * @author Andres Gutierrez <andres@phalconphp.com>
 * @author Eduar Carvajal <eduar@phalconphp.com>
 * @author Wenzel Pünter <wenzel@phelix.me>
 * @version 1.2.6
 * @package Phalcon
*/
namespace UForm\Validation\Validator;

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
class Confirmation extends Validator implements ValidatorInterface
{
	/**
	 * Executes the validation
	 *
	 * @param \UForm\Validation $validator
	 * @param string $attribute
	 * @return boolean
	 * @throws Exception
	 */
	public function validate($validator, $attribute)
	{
		if(is_object($validator) === false ||
			$validator instanceof Validation === false) {
			throw new Exception('Invalid parameter type.');
		}

		if(is_string($attribute) === false) {
			throw new Exception('Invalid parameter type.');
		}

		$with_attribute = $this->getOption('with');
		$value = $validator->getValue($attribute);
		if($value !== $with_attribute) {
			$message = $this->getOption('message');
			if(empty($message) === true) {
				$message = 'Value of \''.$attribute.'\' and \''.$with_attribute.'\' don\'t match';
			}

			$validator->appendMessage(new Message($message, $attribute, 'Confirmation'));
			return false;
		}

		return true;
	}
}