<?php
/**
 * @license see LICENSE
 */

namespace UForm\Render\Html;

class Bootstrap3 extends StandardHtml
{
    public function __construct($options = [])
    {
        $this->setOptions($options);
    }

    public function getTemplatesPathes()
    {
        return array_merge(
            ["Bootstrap3" => __DIR__ . "/../../../renderTemplate/Bootstrap3"],
            parent::getTemplatesPathes()
        );
    }

    /**
     * @inheritdoc
     */
    public function getRenderName()
    {
        return "Bootstrap3";
    }


}
