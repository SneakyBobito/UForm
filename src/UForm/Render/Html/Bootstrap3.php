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

    public function __isset($name)
    {
        switch ($name) {
            case "colNumber":
            case "columnNumber":
                return true;
        }

        return false;
    }

    public function __get($name)
    {

        switch ($name) {
            case "colNumber":
            case "columnNumber":
                return $this->getOption("columnNumber", 12);
        }

        return null;
    }
}
