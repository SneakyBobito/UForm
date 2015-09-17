<?php
/**
 * @license see LICENSE
 */

namespace UForm\Filter;


use UForm\Filter;

/**
 * Performs a ltrim operation on the data
 */
class LeftTrim extends Filter {

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
            return ltrim($v);
        }else{
            return ltrim($v, $this->trimString);
        }
    }


}