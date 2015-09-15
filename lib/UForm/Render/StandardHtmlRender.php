<?php

namespace UForm\Render;


class StandardHtmlRender extends AbstractRender{
    public function getTemplatesPath()
    {
        return __DIR__ . "/../../renderTemplate/StandardHtml";
    }
}