<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Render\Html;

use UForm\Render\AbstractHtmlRender;
use UForm\Render\Html\Foundation5;
use UForm\Test\Render\HtmlRenderTestCase;

class Foundation5Test extends HtmlRenderTestCase
{
    /**
     * @return AbstractHtmlRender
     */
    public function createRender()
    {
        return new Foundation5();
    }
}
