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

    public function testRenderContext(){

        $f = new UForm\Forms\Form();

        $bar = new \UForm\Forms\Element\Text("bar");
        $bar->addValidator(new \UForm\Validation\DirectValidator(function($validator,$self){
            return $validator->getValue() == "rab";
        }));

        $foo = new \UForm\Forms\Element\Collection("foo",$bar);

        $f->add($foo);

        $data = array(
            "foo" => array(
                "bar",
                "rab"
            )
        );

        $f->setData($data);

        $context = $f->renderHelper();


        $fooChildren = $context->getChildren("foo");

        $this->assertEquals(2,count($fooChildren));

        $this->assertEquals("0",reset(array_keys($fooChildren)));
        $this->assertEquals("foo",$fooChildren[0]->getPrename());


        $render =  $context->render($fooChildren[0]);

        $sxe = simplexml_load_string("<root>$render</root>");

        $this->assertEquals(1,$sxe->count());

        $this->assertEquals("bar", $sxe->input[0]["value"]);
        $this->assertEquals("foo[0]", $sxe->input[0]["name"]);

    }

    public function testCollectionValidation(){
        $f = new UForm\Forms\Form();
        
        $bar = new \UForm\Forms\Element\Text("bar");
        $bar->addValidator(new \UForm\Validation\DirectValidator(function($validator,$self){


            return $validator->getValue() == "rab";
        }));
        
        $foo = new \UForm\Forms\Element\Collection("foo",$bar);
        
        $data = array(
            "foo" => array(
                "rab",
                "rab"
            ) 
        );
        $cV = new \UForm\Validation\ChainedValidation($data);
        $foo->prepareValidation($data, $cV);
        $cV->validate();
        $this->assertTrue($cV->isValid());
        

        $data = array(
            "foo" => array(
                "oof","rab"
            ) 
        );
        $cV = new \UForm\Validation\ChainedValidation($data);
        $foo->prepareValidation($data, $cV);
        $cV->validate();
        $this->assertFalse($cV->isValid());
        
        
    }

    public function testGroupValidation(){
        $f = new UForm\Forms\Form();
        
        $bar = new \UForm\Forms\Element\Text("bar");
        $bar->addValidator(new \UForm\Validation\DirectValidator(function($validator,$self){
            return $validator->getValue() == "rab";
        }));
        
        $baz = new \UForm\Forms\Element\Text("baz");
        $baz->addValidator(new \UForm\Validation\DirectValidator(function(UForm\Validation $validator,$self){
            return $validator->getValue() == "zab";
        }));
        
        $foo = new UForm\Forms\Element\Group("foo",array(
            $bar,
            $baz
        ));
        
        
        
        $data = array(
            "foo" => array(
                "bar" => "rab",
                "baz" => "zab"
            ) 
        );
        $cV = new \UForm\Validation\ChainedValidation($data);
        $foo->prepareValidation($data, $cV);
        $cV->validate();
        $this->assertTrue($cV->isValid());
        
        
        
        
        $data = array(
            "foo" => array(
                "bar" => "rab",
                "baz" => "rab"
            ) 
        );
        $cV = new \UForm\Validation\ChainedValidation($data);
        $foo->prepareValidation($data, $cV);
        $cV->validate();
        $this->assertFalse($cV->isValid());
        
        
    }

    public function testDeepRendering(){

        $f = new UForm\Forms\Form();

        $col = new \UForm\Forms\Element\Group("foos", array(
            new \UForm\Forms\Element\Text("fooname"),
            new \UForm\Forms\Element\Text("footype"),

        ));


        $f->add($col);

        $data = array(
            "foos" => array(
                "fooname"=>"bob",
                "footype"=>"silly"
            )
        );

        $f->setData($data);

        // first test : foos.fooname
        //
        $render = $f->render("foos.fooname");

        $sxe = simplexml_load_string("<root>$render</root>");

        $this->assertEquals(1,$sxe->count());

        $this->assertEquals("bob", $sxe->input[0]["value"]);
        $this->assertEquals("foos[fooname]", $sxe->input[0]["name"]);



        // second test : foos.footype
        //
        $render = $f->render("foos.footype");

        $sxe = simplexml_load_string("<root>$render</root>");

        $this->assertEquals(1,$sxe->count());

        $this->assertEquals("silly", $sxe->input[0]["value"]);
        $this->assertEquals("foos[footype]", $sxe->input[0]["name"]);

    }
    
    
    
    public function testTag(){
        
        $t = new \UForm\Tag("input", array("id"=>"myId","required"=>true,"class"=>"class1"), true);
        
        $render = $t->draw(array("id"=>"newId","class"=>"class2"), null);
        
        $this->assertEquals("<input id='newId' required class='class1 class2'/>", $render);
        
    }
    
    
}