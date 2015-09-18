<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test;


use UForm\DataContext;

class DataContextTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var DataContext
     */
    protected $dataContext;
    protected $data;


    public function setUp(){
        $this->data = [

            "lastname" => "simpson",
            "firstname"=> "homer",

            "age" => "40",

            "children" => [

                [
                    "lastname" => "simpson",
                    "firstname"=> "bart",
                    "age" => "12"
                ],

                [
                    "lastname" => "simpson",
                    "firstname"=> "liza",
                    "age" => "10"
                ]

            ]

        ];
        $this->dataContext = new DataContext($this->data);
    }

    public function testFindValue(){
        $homerAge = $this->dataContext->findValue("age");
        $bartAge = $this->dataContext->findValue("children.0.age");
        $lizaInfo = $this->dataContext->findValue("children.1");

        $this->assertEquals(40, $homerAge);
        $this->assertEquals(12, $bartAge);
        $this->assertEquals($this->data["children"][1], $lizaInfo);
    }

    public function testGetDirectValue(){
        $children = $this->dataContext->getDirectValue("children");
        $firstName = $this->dataContext->getDirectValue("firstname");

        $this->assertEquals("homer", $firstName);
        $this->assertEquals($this->data["children"], $children);
    }

    public function testGetArrayCopy(){
        $this->assertInternalType("array", $this->dataContext->getArrayCopy());
        $this->assertSame($this->data, $this->dataContext->getArrayCopy());
    }

    public function testGetIterator(){
        $this->assertInstanceOf("Iterator", $this->dataContext->getIterator());
    }

}
