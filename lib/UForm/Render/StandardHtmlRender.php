<?php
/**
 * Created by PhpStorm.
 * User: sghzal
 * Date: 9/14/15
 * Time: 5:45 PM
 */

namespace UForm\Render;


class StandardHtmlRender extends AbstractRender{
    public function getTemplatesPath()
    {
        return __DIR__ . "/../../renderTemplate/StandardHtml";
    }
}