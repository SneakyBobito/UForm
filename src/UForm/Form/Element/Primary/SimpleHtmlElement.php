<?php
/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Primary;

use UForm\Form\Element\Drawable;
use UForm\Form\Element\Primary;
use UForm\Form\Element\RenderHandlerTrait;
use UForm\Tag;

class SimpleHtmlElement extends Primary implements Drawable
{

    use RenderHandlerTrait;

    protected $htmlTag;
    protected $innerHtml;

    /**
     * CustomHtml constructor.
     * @param $htmlTag
     */
    public function __construct($htmlTag, $innerHtml = null)
    {
        parent::__construct(null);
        $this->htmlTag = $htmlTag;
        $this->innerHtml = $innerHtml;
        $this->addSemanticType('simpleHtmlElement');
    }

    /**
     * @inheritdoc
     */
    public function render($localData, array $options = [], \UForm\Form\FormContext $formContext = null)
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

        $tag = new Tag($this->htmlTag, $params, null === $this->innerHtml || false === $this->innerHtml);
        return $tag->draw(null, $this->innerHtml);
    }
}
