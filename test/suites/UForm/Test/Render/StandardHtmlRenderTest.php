<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Render;

use UForm\Render\StandardHtmlRender;

class StandardHtmlRenderTest extends \PHPUnit_Framework_TestCase
{

    public function testDirectoryExistance()
    {
        $standardHtmlRender = new StandardHtmlRender();

        $file = current($standardHtmlRender->getTemplatesPathes());

        $this->assertTrue(file_exists($file));
        $this->assertTrue(is_dir($file));


    }
}
