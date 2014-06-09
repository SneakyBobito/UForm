<?php

/**
 * CommonTest
 *
 * @author sghzal
 */
class ElementTest extends PHPUnit_Framework_TestCase
{

    public function testCollection(){
        
        $f = new UForm\Forms\Form();
        
        $col = new \UForm\Forms\Element\Collection("foos",new \UForm\Forms\Element\Text("fooname"));
       
        $f->add($col);
        
        $data = array(
            "foos" => array(
                array(
                    "fooname"=>"foo1"
                ),
                array(
                    "fooname"=>"foo2"
                )
            )
        );
        
        $f->setData($data);
        
        $render = $f->render("foos");
        
        $sxe = simplexml_load_string("<root>$render</root>");
        
        $this->assertEquals(2,$sxe->count());
        
        $this->assertEquals("foo1", $sxe->input[0]["value"]);
        $this->assertEquals("foo2", $sxe->input[1]["value"]);
        $this->assertEquals("foos[0][fooname]", $sxe->input[0]["name"]);
        $this->assertEquals("foos[1][fooname]", $sxe->input[1]["name"]);
        
    }
    
    
    
}
