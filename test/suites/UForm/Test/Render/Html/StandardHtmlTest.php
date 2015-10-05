<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Render\Html;

use UForm\Render\AbstractHtmlRender;
use UForm\Render\Html\StandardHtml;
use UForm\Test\Render\HtmlRenderTestCase;

class StandardHtmlTest extends HtmlRenderTestCase
{
    /**
     * @return AbstractHtmlRender
     */
    public function createRender()
    {
        return new StandardHtml();
    }
}
