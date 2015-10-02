<?php

namespace UForm\Render\Html;

use UForm\Render\AbstractHtmlRender;

class StandardHtml extends AbstractHtmlRender
{
    public function getTemplatesPathes()
    {
        return ["StandarHtml" => __DIR__ . "/../../../renderTemplate/StandardHtml"];
    }
}
