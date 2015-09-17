<?php
/**
 * @license see LICENSE
 */

namespace UForm\Filter;


use UForm\Filter;

/**
 * Performs a rtrim operation on the data
 */
class RightTrim extends Filter {

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
            return rtrim($v);
        }else{
            return rtrim($v, $this->trimString);
        }
    }


}