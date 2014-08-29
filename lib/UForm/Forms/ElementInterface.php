<?php
/**
 * Element Interface
 *
 * @author Andres Gutierrez <andres@phalconphp.com>
 * @author Eduar Carvajal <eduar@phalconphp.com>
 * @version 1.2.6
 * @package Phalcon
*/
namespace UForm\Forms;

use UForm\Validation\ChainedValidation;

/**
 * Phalcon\Forms\ElementInterface initializer
 * 
 * @see https://github.com/phalcon/cphalcon/blob/1.2.6/ext/forms/elementinterface.c
 */
interface ElementInterface
{
	/**
	 * Sets the parent form to the element
	 *
	 * @param \Phalcon\Forms\Form $form
	 * @return \Phalcon\Forms\ElementInterface
	 */
	public function setForm($form);

	/**
	 * Returns the parent form to the element
	 *
	 * @return \Phalcon\Forms\ElementInterface
	 */
	public function getForm();

	/**
	 * Sets the element's name
	 *
	 * @param string $name
	 * @return \Phalcon\Forms\ElementInterface
	 */
	public function setName($name);

	/**
	 * Returns the element's name
	 *
	 * @return string
	 */
	public function getName();

	/**
	 * Sets the element's filters
	 *
	 * @param array|string $filters
	 * @return \Phalcon\Forms\ElementInterface
	 */
	public function setFilters($filters);

	/**
	 * Adds a filter to current list of filters
	 *
	 * @param string $filter
	 * @return \Phalcon\Forms\ElementInterface
	 */
	public function addFilter($filter);

	/**
	 * Returns the element's filters
	 *
	 * @return mixed
	 */
	public function getFilters();

	/**
	 * Adds a group of validators
	 *
	 * @param \Phalcon\Validation\ValidatorInterface[]
	 * @return \Phalcon\Forms\ElementInterface
	 */
	public function addValidators($validators, $merge = null);

	/**
	 * Adds a validator to the element
	 *
	 * @param \Phalcon\Validation\ValidatorInterface
	 * @return \Phalcon\Forms\ElementInterface
	 */
	public function addValidator($validator);

	/**
	 * Returns the validators registered for the element
	 *
	 * @return \Phalcon\Validation\ValidatorInterface[]
	 */
	public function getValidators();


      


	/**
	 * Clears every element in the form to its default value
	 *
	 * @return \Phalcon\Forms\Element
	 */
	public function clear();

	/**
	 * Renders the element widget
	 *
	 * @param array $attributes
	 * @return string
	 */
	public function render( $attributes , $value , $data , $prename = null);
        
        /**
         * 
         * @param type $value
         * @param type $data
         * @param type $messages
         * @return \UForm\Validation
         */
        public function  prepareValidation($localValues,  ChainedValidation $cV , $prename = null);
        
}