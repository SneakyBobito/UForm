<?php
/**
 * @license see LICENSE
 */

namespace UForm\Render;

class Bootstrap3Render extends StandardHtmlRender
{
    public function __construct($options = [])
    {
        $this->setOptions($options);
    }

    public function getTemplatesPathes()
    {
        return array_merge(
            ["Bootstrap3" => __DIR__ . "/../../renderTemplate/Bootstrap3"],
            parent::getTemplatesPathes()
        );
    }
}
