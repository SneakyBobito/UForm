<?php
/**
 * Identical Validator
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
	\UForm\Validation\Message,
	\UForm\Validation\Exception,
	\UForm\Validation;

/**
 * Phalcon\Validation\Validator\Identical
 *
 * Checks if a value is identical to other
 *
 *<code>
 *use Phalcon\Validation\Validator\Identical;
 *
 *$validator->add('terms', new Identical(array(
 *   'value'   => 'yes',
 *   'message' => 'Terms and conditions must be accepted'
 *)));
 *</code>
 *
 * @see https://github.com/phalcon/cphalcon/blob/1.2.6/ext/validation/validator/identical.c
 */
class Identical extends Validator implements ValidatorInterface
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

		if($validator->getValue($attribute) !== $this->getOption('value')) {
			$message = $this->getOption('message');
			if(empty($message) === true) {
				$message = $attribute.' does not have the expected value';
			}

			$validator->appendMessage(new Message($message, $attribute, 'Identical'));

			return false;
		}

		return true;
	}
}