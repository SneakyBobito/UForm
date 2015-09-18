<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test;


use UForm\Form;
use UForm\Navigator;

class NavigatorTest extends \PHPUnit_Framework_TestCase {


    public function testArrayGet()
    {
        $navigator = new Navigator();

        $data = [

            "str1" => "str1val",
            "str2" => "str2val",
            "arr1" => [
                "arr1str1" => "arr1str1val",
                "arr1str2" => "arr1str2val",
                "arr1arr1" => [
                    "arr1arr1str1" => "arr1arr1str1val",
                    "arr1arr1str2" => "arr1arr2str1val"
                ]
            ],
            "arr2" => [
            ],
            "str3" => "str3val",

        ];

        $this->assertEquals($data, $navigator->arrayGet($data, ""));
        $this->assertEquals("str1val", $navigator->arrayGet($data, "str1"));
        $this->assertEquals("str2val", $navigator->arrayGet($data, "str2"));
        $this->assertEquals($data["arr1"], $navigator->arrayGet($data, "arr1"));
        $this->assertEquals([], $navigator->arrayGet($data, "arr2"));
        $this->assertEquals("str3val", $navigator->arrayGet($data, "str3"));
        $this->assertEquals("arr1arr2str1val", $navigator->arrayGet($data, "arr1.arr1arr1.arr1arr1str2"));
    }

}
