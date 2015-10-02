<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Render\Html;


use UForm\Render\AbstractHtmlRender;
use UForm\Render\Html\Bootstrap3;
use UForm\Test\Render\HtmlRenderTestCase;

class Bootstrap3Test extends HtmlRenderTestCase {
    /**
     * @return AbstractHtmlRender
     */
    public function createRender()
    {
        return new Bootstrap3();
    }


}
