<?php
/**
 * @license see LICENSE
 */

namespace UForm\Filter;

use UForm\Filter;

/**
 * Equivalent to the php rtrim function
 *
 * @link http://php.net/rtrim
 * @see \UForm\Filter\Trim
 * @see \UForm\Filter\LeftTrim
 *
 * <code>
 * $filter = new RightTrim();
 *
 * var_dump($filter->filter(" foo "));
 *
 * // > string(4) " foo"
 * </code>
 *
 * <code>
 *  $filter = new RightTrim("-");
 *
 * var_dump($filter->filter("- foo -"));
 *
 * // > string(6) "- foo "
 * </code>
 *
 */
class RightTrim extends Filter
{

    protected $trimString;

    /**
     * characters to trim (default only whitespaces)
     * @param string|null $trimString the characters to trim
     */
    public function __construct($trimString = null)
    {
        $this->trimString = $trimString;
    }

    /**
     * @inheritdoc
     */
    public function filter($v)
    {
        if (null === $v) {
            return $v;
        }

        if (null == $this->trimString) {
            return rtrim($v);
        } else {
            return rtrim($v, $this->trimString);
        }
    }
}
