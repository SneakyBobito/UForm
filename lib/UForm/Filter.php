<?php
/**
 * Filter
 */
namespace UForm;

use \UForm\FilterInterface;

/**
 * UForm\Filter
 *
 * Base class for user defined filter. Extend it and overide filter method 
 * 
 */
abstract class Filter
{
    
    public function filter($v){
        return $v;
    }
	
}