<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test;

use UForm\DataContext;

class DataContextTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var DataContext
     */
    protected $dataContextArray;
    /**
     * @var DataContext
     */
    protected $dataContextString;
    protected $data;


    public function setUp()
    {
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
                    "firstname"=> "lisa",
                    "age" => "10"
                ]

            ]

        ];
        $this->dataContextArray = new DataContext($this->data);

        $this->dataContextString = new DataContext("stringData");
    }

    public function testFindValue()
    {
        $homerAge = $this->dataContextArray->findValue("age");
        $bartAge = $this->dataContextArray->findValue("children.0.age");
        $lisaInfo = $this->dataContextArray->findValue("children.1");
        $this->assertEquals(40, $homerAge);
        $this->assertEquals(12, $bartAge);
        $this->assertEquals($this->data["children"][1], $lisaInfo);


        $this->assertNull($this->dataContextString->findValue("age"));
    }

    public function testGetDirectValue()
    {
        $children = $this->dataContextArray->getDirectValue("children");
        $firstName = $this->dataContextArray->getDirectValue("firstname");

        $this->assertEquals("homer", $firstName);
        $this->assertEquals($this->data["children"], $children);

        $this->assertNull($this->dataContextString->getDirectValue("age"));
    }

    public function testGetDataCopy()
    {
        $this->assertInternalType("array", $this->dataContextArray->getDataCopy());
        $this->assertSame($this->data, $this->dataContextArray->getDataCopy());

        $this->assertEquals("stringData", $this->dataContextString->getDataCopy());
    }

    public function testIsArray()
    {
        $this->assertTrue($this->dataContextArray->isArray());
        $this->assertFalse($this->dataContextString->isArray());
    }

    public function testGetIterator()
    {
        $this->assertInstanceOf("Iterator", $this->dataContextArray->getIterator());
        $this->assertEquals($this->data, $this->dataContextArray->getIterator()->getArrayCopy());

        $this->assertInstanceOf("Iterator", $this->dataContextString->getIterator());
        $this->assertEquals([], $this->dataContextString->getIterator()->getArrayCopy());
    }
}
