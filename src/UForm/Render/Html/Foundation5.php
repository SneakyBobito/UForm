<?php
/**
 * @license see LICENSE
 */

namespace UForm\Render\Html;

use UForm\Render\AbstractHtmlRender;

class Foundation5 extends AbstractHtmlRender
{


    public function __construct(array $options = [])
    {
        $this->setOptions($options);
    }

    /**
     * @inheritdoc
     */
    public function getTemplatesPathes()
    {
        return [
            'Foundation5' => __DIR__ . '/../../../renderTemplate/Foundation5'
        ];
    }

    /**
     * @inheritdoc
     */
    public function getRenderName()
    {
        return 'Foundation5';
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
