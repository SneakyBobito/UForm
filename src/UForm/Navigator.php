<?php

namespace UForm;

use UForm\Form;
use UForm\Form\Element\Container;

/**
 * Utility class to get data from an array by its path
 *
 * <code>
 *
 * $data = [
 *      "subData" => [
 *          ["name" : "john"],
 *          ["name" : "bob"]
 *      ]
 * ];
 *
 * $navigator = new Navigator();
 *
 * $name = $navigator->arrayGet($data, "subData.1.name");
 *
 * var_dump($name);
 *
 * // > string(3) "bob"
 *
 * </code>
 *
 */
class Navigator
{


    /**
     * @param array $data  locals values (context aware). Most of time same as $global
     * @param string $string  the navigation string. e.g :
     * "foo.bar.0". If begins with a dot e.g ".bar.0"
     * the local context context will be use or else we use the global one.
     * @param int $rOffset  the reversed offset default 0.
     * With the string "foo.bar.0" | $rOffset=0 will get "foo.bar.0"
     * |  $rOffset=1 will get "foo.bar" |  $rOffset=2 will get "foo"
     * @return null
     */
    public function arrayGet(array $data, $string, $rOffset = 0)
    {

        if (is_null($string) || empty($string)) {
            return $data;
        }


        $stringParts = explode(".", $string);

        if ($rOffset>0) {
            for ($i=0; $i<$rOffset; $i++) {
                array_pop($stringParts);
            }
        }

        while (!empty($stringParts)) {
            $newName = array_shift($stringParts);
            if (!isset($data[$newName])) {
                return null;
            } else {
                $data = $data[$newName];
            }
        }
        
        return $data;
        
    }
}
