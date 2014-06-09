<?php
/**
 * ExclusionIn Validator
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
 * Phalcon\Validation\Validator\ExclusionIn
 *
 * Check if a value is not included into a list of values
 *
 *<code>
 *use Phalcon\Validation\Validator\ExclusionIn;
 *
 *$validator->add('status', new ExclusionIn(array(
 *   'message' => 'The status must not be A or B',
 *   'domain' => array('A', 'B')
 *)));
 *</code>
 * 
 * @see https://github.com/phalcon/cphalcon/blob/1.2.6/ext/validation/validator/exclusionin.c
 */
class ExclusionIn extends Validator implements ValidatorInterface
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

		//A domain is an array with a list of valid values
		$domain = $this->getOption('domain');
		if(is_array($domain) === false) {
			throw new Exception("Option 'domain' must be an array");
		}

		//Check if the value is contained in the array
		if(in_array($value, $domain) === true) {
			$message = $this->getOption('message');
			if(empty($message) === true) {
				$message = "Value of field '".$attribute."' must not be part of list: ".implode(', '.$domain);
			}

			$validator->appendMessage(new Message($message, $attribute, 'ExclusionIn'));

			return false;
		}

		return true;
	}
}