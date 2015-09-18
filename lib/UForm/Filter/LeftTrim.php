<?php
/**
 * @license see LICENSE
 */

namespace UForm\Filter;


use UForm\Filter;

/**
 * Equivalent to the php ltrim function
 *
 * @link http://php.net/ltrim
 * @see \UForm\Filter\Trim
 * @see \UForm\Filter\RightTrim
 *
 * <code>
 *  $filter = new LeftTrim();
 *
 * var_dump($filter->filter(" foo "));
 *
 * // > string(4) "foo "
 * </code>
 *
 * <code>
 *  $filter = new LeftTrim("-");
 *
 * var_dump($filter->filter("- foo -"));
 *
 * // > string(6) " foo -"
 * </code>
 *
 */
class LeftTrim extends Filter {

    protected $trimString;

    /**
     * characters to trim (default only whitespaces)
     * @param null $trimString
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
            return ltrim($v);
        }else{
            return ltrim($v, $this->trimString);
        }
    }


}