<?php
/**
 * Password
 *
 * @author Andres Gutierrez <andres@phalconphp.com>
 * @author Eduar Carvajal <eduar@phalconphp.com>
 * @author Wenzel Pünter <wenzel@phelix.me>
 * @version 1.2.6
 * @package Phalcon
*/
namespace UForm\Forms\Element;

use \UForm\Tag,
	\UForm\Forms\Element,
	\UForm\Forms\ElementInterface,
	\UForm\Forms\Exception;

/**
 * Phalcon\Forms\Element\Password
 *
 * Component INPUT[type=password] for forms
 *
 * @see https://github.com/phalcon/cphalcon/blob/1.2.6/ext/forms/element/password.c
 */
class Password extends Element implements ElementInterface
{
	/**
	 * Renders the element widget returning html
	 *
	 * @param array $attributes
	 * @return string
	 * @throws Exception
	 */
	public function render($attributes = null)
	{
		if(is_null($attributes) === false &&
			is_array($attributes) === false) {
			throw new Exception('Invalid parameter type.');
		}

		return Tag::passwordField($this->prepareAttributes($attributes));
	}
}