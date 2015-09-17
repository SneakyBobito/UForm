<?php

namespace UForm\Filter;

use UForm\Filter;

/**
 * Usefull to create filter on the fly by only passing a callback function
 */
class DirectClosure extends Filter {
    
    public $closure;
    
    function __construct($closure) {
        $this->closure = $closure;
    }
    
    public function filter($v) {
        $closure = $this->closure;
        return $closure($v);
    }
}