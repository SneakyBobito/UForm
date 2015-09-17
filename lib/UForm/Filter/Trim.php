<?php
/**
 * @license see LICENSE
 */

namespace UForm\Filter;


use UForm\Filter;

/**
 * Performs a trim operation on the data
 */
class Trim extends Filter {

    protected $trimString;

    function __construct($trimString = null){
        $this->trimString = $trimString;
    }

    /**
     * @inheritdoc
     */
    public function filter($v)
    {
        if(null === $v){
            return $v;
        }
        
        if(null == $this->trimString){
            return trim($v);
        }else{
            return trim($v, $this->trimString);
        }
    }


}