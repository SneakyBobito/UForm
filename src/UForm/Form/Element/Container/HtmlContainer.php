<?php

/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Container;

use UForm\Form\Element;
use UForm\Tag;

/**
 * @semanticType rawTtml
 */
class HtmlContainer extends Group
{

    use Element\RenderHandlerTrait;

    protected $htmlTag;

    /**
     * CustomHtml constructor.
     * @param $htmlTag
     */
    public function __construct($htmlTag)
    {
        parent::__construct(null);
        $this->htmlTag = $htmlTag;
        $this->addSemanticType('htmlContainer');
    }


    /**
     * @param $localData
     * @param array $options
     * @return Tag
     */
    public function getTag(array $options = [])
    {
        $options = $this->processRenderOptionHandlers([], $options);

        $params = [];

        foreach ($this->getAttributes() as $attrName => $attrValue) {
            $params[$attrName] = $attrValue;
        }

        if (isset($options['class'])) {
            if (isset($params['class'])) {
                $params['class'] .= ' ' . $options['class'];
            } else {
                $params['class'] = $options['class'];
            }
        }

        return new Tag($this->htmlTag, $params, false);
    }
}
