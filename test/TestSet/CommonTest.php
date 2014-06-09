<?php

/**
 * CommonTest
 *
 * @author sghzal
 */
class CommonTest extends PHPUnit_Framework_TestCase
{

    public function testBind(){
        
        $f = new UForm\Forms\Form();
        
        $f->add(new \UForm\Forms\Element\Text("foo"));
        $f->add(new \UForm\Forms\Element\Text("bar"));
        $f->add(new \UForm\Forms\Element\Text("baz"));
        
        $data = array(
            "foo" => "oof",
            "baz" => "zab",
            "bla" => "alb"
        );
        
        $rec = new stdClass();
        
        $f->setData($data);
        $f->bind($rec);
        
        $this->assertEquals("oof",$rec->foo);
        $this->assertEquals("zab",$rec->baz);
        $this->assertEquals(2, count(get_object_vars($rec)));
        
    }
    
    public function testFilter(){
        
        $f = new UForm\Forms\Form();
        
        $foo = new \UForm\Forms\Element\Text("foo");
        $foo->addFilter(new UForm\DirectFilter(function($v){
            return "+".$v;
        }));
        
        $bar = new \UForm\Forms\Element\Text("bar");
        $bar->addFilter(new UForm\DirectFilter(function($v){
            return "{" . $v;
        }));
        $bar->addFilter(function($v){
            return $v . "}";
        });
        
        $f->add($foo);
        $f->add($bar);
        $f->add(new \UForm\Forms\Element\Text("baz"));
        
        $data = array(
            "foo" => "oof",
            "baz" => "zab",
            "bla" => "alb",
            "bar" => "rab"
        );
        
        $rec = new stdClass();
        
        $f->setData($data);
        $f->bind($rec);
        
        $this->assertEquals("+oof",$rec->foo);
        $this->assertEquals("zab",$rec->baz);
        $this->assertEquals("{rab}",$rec->bar);
        
    }
    
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
        
        echo $f->render("foos");
        
        
    }
    
}