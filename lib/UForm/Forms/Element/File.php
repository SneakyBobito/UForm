<?php
/**
 * File
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
 * Phalcon\Forms\Element\File
 *
 * Component INPUT[type=file] for forms
 * 
 * @see https://github.com/phalcon/cphalcon/blob/1.2.6/ext/forms/element/file.c
 */
class File extends Element implements ElementInterface
{
	/**
	 * Renders the element widget returning html
	 *
	 * @param array|null $attributes
	 * @return string
	 * @throws Exception
	 */
	public function render($attributes = null)
	{
		if(is_array($attributes) === false &&
			is_null($attributes) === false) {
			throw new Exception('Invalid parameter type.');
		}

		return Tag::emailField($this->fileField($attributes));
	}
}