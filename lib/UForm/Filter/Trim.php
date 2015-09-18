<?php
/**
 * @license see LICENSE
 */

namespace UForm\Filter;


use UForm\Filter;

/**
 * Equivalent to the php trim function
 *
 * @link http://php.net/trim
 * @see \UForm\Filter\RightTrim
 * @see \UForm\Filter\LeftTrim
 *
 * <code>
 * $filter = new Trim();
 *
 * var_dump($filter->filter(" foo "));
 *
 * // > string(3) "foo"
 * </code>
 *
 * <code>
 *  $filter = new Trim("-");
 *
 * var_dump($filter->filter("- foo -"));
 *
 * // > string(5) " foo "
 * </code>
 *
 */
class Trim extends Filter {

    protected $trimString;

    /**
     * characters to trim (default only whitespaces)
     * @param string|null $trimString the characters to trim
     */
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