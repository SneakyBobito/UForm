<?php

namespace UForm;

use UForm\Filter;

/**
 * Description of DirectFilter
 *
 * @author sghzal
 */
class DirectFilter extends Filter {
    
    public $closure;
    
    function __construct($closure) {
        $this->closure = $closure;
    }
    
    public function filter($v) {
        $closure = $this->closure;
        return $closure($v);
    }

    
}