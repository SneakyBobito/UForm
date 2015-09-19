<?php

namespace UForm\Filter;

use UForm\Filter;

/**
 * Usefull to create filter on the fly by only passing a callback function
 * the filter method will use this closure by passing the filtered value as the first parameter
 *
 * <code>
 *  $directClosure = new DirectClosure(
 *      function($v){
 *          return 'foo' . $v;
 *      }
 * );
 *
 * var_dump($directClosure->filter("bar"));
 *
 * // > string(6) "foobar"
 * </code>
 *
 */
class DirectClosure extends Filter {

    /**
     * @var callable
     */
    public $closure;

    /**
     * @param callable $closure the closure that will be called during filtering. The closure first parameter will be the filtered value
     */
    function __construct(callable $closure) {
        $this->closure = $closure;
    }

    /**
     * get the internal closure
     * @return callable
     */
    public function getClosure(){
        return $this->closure;
    }

    /**
     * @inheritdoc
     */
    public function filter($v) {
        $closure = $this->closure;
        return $closure($v);
    }
}