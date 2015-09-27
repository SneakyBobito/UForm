<?php

namespace UForm\Render;

class StandardHtmlRender extends AbstractRender
{
    public function getTemplatesPathes()
    {
        return ["StandarHtml" => __DIR__ . "/../../renderTemplate/StandardHtml"];
    }
}
