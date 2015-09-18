<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test;

class TagTest extends \PHPUnit_Framework_TestCase {


    public function testTag(){
        $t = new \UForm\Tag("input", array("id"=>"myId","required"=>true,"class"=>"class1"), true);
        $render = $t->draw(array("id"=>"newId","class"=>"class2", "something" => "somevalue"), null);
        $this->assertEquals('<input id="newId" required class="class1 class2" something="somevalue"/>', $render);
    }
}
