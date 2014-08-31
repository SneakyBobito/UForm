<?php

/**
 * CommonTest
 *
 * @author sghzal
 */
class CommonTest extends PHPUnit_Framework_TestCase
{

    /**
     * @group setform
     */
    public function testSetForm(){
        
        $f = new UForm\Forms\Form();
        
        $f->add(new \UForm\Forms\Element\Text("foo"));

        
        $bar = new \UForm\Forms\Element\Text("bar");
        
        $baz = new \UForm\Forms\Element\Text("baz");
        
        $foo = new UForm\Forms\Element\Group("groupe",array(
            $bar,
            $baz
        ));
        
        $f->add($foo);
        
        $this->assertEquals($f, $bar->getForm());
        $this->assertEquals($f, $baz->getForm());
        $this->assertEquals($f, $f->get("groupe")->getForm());
        $this->assertEquals($f, $f->get("foo")->getForm());
        
    }
    
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

    
    public function testWrapper(){
        
        $f = new UForm\Forms\Form();
        
        $bar = new \UForm\Forms\Element\Text("bar");
        $bar->addValidator(new \UForm\Validation\DirectValidator(function($validator,$self){
            if($validator->getValue() != "rab"){
                $validator->appendMessage("bar not valid");
                return false;
            }
        }));
        
        $foo = new \UForm\Forms\ElementWrapper($bar);
        $f->add($foo);
        
        
        // TESTS
        
        // 1
        $data = array(
            "bar" => "rab"
        );
        $f->setData($data);
        $this->assertEquals(true, $f->formIsValid());
        
        
        // 2
        $data = array(
            "bar" => "bar"
        );
        $f->setData($data);
        $this->assertEquals(false, $f->formIsValid());
        $messages =$f->getElementMessages("bar");
        $this->assertEquals("bar not valid", $messages[0]);
        
        
        // 3
        $this->assertEquals($f,$foo->getForm());
        $this->assertEquals($f,$bar->getForm());
        
        
        // 4
        $f2 = new \UForm\Forms\Form();
        $f2->add($bar);
        $f2->setData($data);
        $barRender1 = $f->renderElement("bar");
        $barRender2 = $f2->renderElement("bar");
        
        $this->assertTrue(!empty($barRender1));
        $this->assertEquals($barRender1, $barRender2);
        
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

    /**
     * @group groupvalidation
     */
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
        
        $f->add($foo);
        
        
        
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
        
        $f->setData($data);
        $this->assertTrue($f->elementChildrenAreValid($foo));
        
        
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
        
        $f->setData($data);
        $this->assertFalse($foo->childrenAreValid($cV));
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
        $render = $f->renderElement("foos.fooname");

        $sxe = simplexml_load_string("<root>$render</root>");

        $this->assertEquals(1,$sxe->count());

        $this->assertEquals("bob", $sxe->input[0]["value"]);

        $this->assertEquals("foos[fooname]", $sxe->input[0]["name"]);



        // second test : foos.footype
        //
        $render = $f->renderElement("foos.footype");

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