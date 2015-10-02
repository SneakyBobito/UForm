<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Render\Html;

use UForm\Render\Html\StandardHtml;

class StandardHtmlRenderTest extends \PHPUnit_Framework_TestCase
{

    public function testDirectoryExistance()
    {
        $standardHtmlRender = new StandardHtml();

        $file = current($standardHtmlRender->getTemplatesPathes());

        $this->assertTrue(file_exists($file));
        $this->assertTrue(is_dir($file));


    }
}
