<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Render;


use UForm\Render\StandardHtmlRender;

class StandardHtmlRenderTest extends \PHPUnit_Framework_TestCase {

    public function testDirectoryExistance(){
        $standardHtmlRender = new StandardHtmlRender();

        $this->assertTrue(file_exists($standardHtmlRender->getTemplatesPath()));
        $this->assertTrue(is_dir($standardHtmlRender->getTemplatesPath()));


    }

}
