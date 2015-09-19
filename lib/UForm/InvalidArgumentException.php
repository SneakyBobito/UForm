<?php
/**
 * @license see LICENSE
 */

namespace UForm;


class InvalidArgumentException extends Exception{


    function __construct($argumentName, $expectedType, $argument, $message = null)
    {
        $actualType = gettype($argument);
        $finalMessage = "Invalid type for argument $argumentName. $actualType given but $expectedType expected.";

        if($message){
            $finalMessage .= " " . $message;
        }

        parent::__construct($finalMessage);

    }
}