<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test;

use UForm\Tag;

class TagTest extends \PHPUnit_Framework_TestCase
{


    public function testTag()
    {
        $t = new \UForm\Tag('input', ['id'=>'myId','required'=>true,'class'=>'class1'], true);
        $render = $t->draw(['id'=>'newId','class'=>'class2', 'something' => 'somevalue'], null);
        $this->assertEquals('<input id="newId" required class="class1 class2" something="somevalue"/>', $render);

        // no property
        $t = new \UForm\Tag('input', [], true);
        $render = $t->draw();
        $this->assertEquals('<input/>', $render);


        // unclosed tag
        $t = new \UForm\Tag('select', ['id'=>'myId','required'=>true,'class'=>'class1']);
        $render = $t->draw(['id'=>'newId','class'=>'class2', 'something' => 'somevalue'], 'options go here');
        $this->assertEquals(
            '<select id="newId" required class="class1 class2" something="somevalue">options go here</select>',
            $render
        );

        // no property
        $t = new \UForm\Tag('select');
        $render = $t->draw();
        $this->assertEquals('<select></select>', $render);

        // base properties but no draw properties
        $t = new \UForm\Tag('select', ['id' => 'myId']);
        $render = $t->draw();
        $this->assertEquals('<select id="myId"></select>', $render);

        // draw properties (class) but no base properties
        $t = new \UForm\Tag('select');
        $render = $t->draw(['class' => 'class1']);
        $this->assertEquals('<select class="class1"></select>', $render);
    }

    public function testOpenClose()
    {

        $tag = new Tag('foo', ['bar' => 'baz']);

        $this->assertEquals('<foo bar="baz">', $tag->open());
        $this->assertEquals('</foo>', $tag->close());
    }
}
