<?php
/**
 * Text
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
 * Phalcon\Forms\Element\Text
 *
 * Component INPUT[type=text] for forms
 *
 * @see https://github.com/phalcon/cphalcon/blob/1.2.6/ext/forms/element/text.c
 */
class Text extends Element implements ElementInterface
{
        /**
         * Renders the element widget
         *
         * @param array|null $attributes
         * @return string
         * @throws Exception
         */
        public function render( $attributes , $value , $data , $prename = null ){
            return "input value= " . $value[$this->getName()] . " name=" . $this->getName($prename);
        }
}