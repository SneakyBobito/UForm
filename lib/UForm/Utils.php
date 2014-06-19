<?php

/**
 * @copyright (c) Rock A Gogo VPC
 */

namespace UForm;

/**
 * Utils
 *
 * @author sghzal
 */
class Utils {

    public static function objectToArrayRecursive($obj){
        $final = array();
        $data = is_object($obj) ? (array) $obj : $obj;
        foreach ($data as $k=>$v){
            $final[$k] = (is_array($v) || is_object($v)) ? self::objectToArrayRecursive($v) : $v;
        }
        return $final;
    }
    
}