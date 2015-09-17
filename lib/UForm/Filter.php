<?php
/**
 * Filter
 */
namespace UForm;


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