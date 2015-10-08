<?php
/**
 * @license see LICENSE
 */

namespace UForm\Render\Html;

use UForm\Render\AbstractHtmlRender;

class Materialize0 extends AbstractHtmlRender
{
    public function __construct($options = [])
    {
        $this->setOptions($options);
    }

    public function getTemplatesPathes()
    {
        return ["Materialize0" => __DIR__ . "/../../../renderTemplate/Materialize0"];
    }

    /**
     * @inheritdoc
     */
    public function getRenderName()
    {
        return "Materialize0";
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
