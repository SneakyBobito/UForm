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
    
    
    public function testText(){
        
        $f = new UForm\Forms\Form();
        
        $elm = new UForm\Forms\Element\Text("foo");
       
        $f->add($elm);
        
        $data = array(
            "foo" => "oof"
        );
        
        $f->setData($data);
        $f->validate();
        $render = $f->render("foo");

        $sxe = simplexml_load_string("<root>$render</root>");
        
        $this->assertEquals(1,$sxe->count());
        
        $this->assertEquals("oof", $sxe->input[0]["value"]);
        $this->assertEquals("text", $sxe->input[0]["type"]);
        $this->assertEquals("foo", $sxe->input[0]["name"]);
        
    }
    
    public function testPassword(){
        
        $f = new UForm\Forms\Form();
        
        $elm = new UForm\Forms\Element\Password("foo");
       
        $f->add($elm);
        
        $data = array(
            "foo" => "oof"
        );
        
        $f->setData($data);
        $f->validate();
        $render = $f->render("foo");

        $sxe = simplexml_load_string("<root>$render</root>");
        
        $this->assertEquals(1,$sxe->count());
        
        $this->assertEquals("oof", $sxe->input[0]["value"]);
        $this->assertEquals("password", $sxe->input[0]["type"]);
        $this->assertEquals("foo", $sxe->input[0]["name"]);
        
    }
    
    public function testHidden(){
        
        $f = new UForm\Forms\Form();
        
        $elm = new \UForm\Forms\Element\Hidden("foo");
       
        $f->add($elm);
        
        $data = array(
            "foo" => "oof"
        );
        
        $f->setData($data);
        $f->validate();
        $render = $f->render("foo");

        $sxe = simplexml_load_string("<root>$render</root>");
        
        $this->assertEquals(1,$sxe->count());
        
        $this->assertEquals("oof", $sxe->input[0]["value"]);
        $this->assertEquals("hidden", $sxe->input[0]["type"]);
        $this->assertEquals("foo", $sxe->input[0]["name"]);
        
    }
    
    
    
    public function testCheckGroup(){
        
        $f = new UForm\Forms\Form();
        
        $elm = new \UForm\Forms\Element\CheckGroup("foo", array(
            "bla","blabla","blablabla"
        ));
       
        $f->add($elm);
        
        $data = array(
            "foo" => array(
                "bla"
            )
        );
        
        $f->setData($data);
        $f->validate();
        $render = $f->render("foo");
        
        $sxe = simplexml_load_string("<root>$render</root>");
        
        $this->assertEquals(3,$sxe->count());
        
        $this->assertEquals("bla", $sxe->input[0]["value"]);
        $this->assertEquals("blabla", $sxe->input[1]["value"]);
        $this->assertEquals("blablabla", $sxe->input[2]["value"]);
        
        $this->assertEquals("foo[0]", $sxe->input[0]["name"]);
        $this->assertEquals("foo[1]", $sxe->input[1]["name"]);
        $this->assertEquals("foo[2]", $sxe->input[2]["name"]);
        
        $this->assertEquals("checked", $sxe->input[0]["checked"]);
        $this->assertEquals(null, $sxe->input[1]["checked"]);
        $this->assertEquals(null, $sxe->input[2]["checked"]);
        
        $this->assertEquals("checkbox", $sxe->input[0]["type"]);
        $this->assertEquals("checkbox", $sxe->input[1]["type"]);
        $this->assertEquals("checkbox", $sxe->input[2]["type"]);
        
        
    }
    
    
    
    
}
