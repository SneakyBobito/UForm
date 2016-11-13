<?php
/**
 * @license see LICENSE
 */

namespace UForm\Render\Html;

use UForm\Render\AbstractHtmlRender;

class Bootstrap3 extends AbstractHtmlRender
{
    public function __construct($options = [])
    {
        $this->setOptions($options);
    }

    public function getTemplatesPaths()
    {
        return ['Bootstrap3' => __DIR__ . '/../../../renderTemplate/Bootstrap3'];
    }

    /**
     * @inheritdoc
     */
    public function getRenderName()
    {
        return 'Bootstrap3';
    }

    public function __isset($name)
    {
        switch ($name) {
            case 'colNumber':
            case 'columnNumber':
                return true;
        }

        return false;
    }

    public function __get($name)
    {

        switch ($name) {
            case 'colNumber':
            case 'columnNumber':
                return $this->getOption('columnNumber', 12);
        }

        return null;
    }
}
